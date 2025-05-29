<?php
namespace App\Http\Livewire;

use Livewire\Component;
// use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class Payroll extends Component
{
    public $payroll_period_start, $payroll_period_end, $payment_date, $notes;
    public $payrolls = [];

    public function mount()
    {
        $this->payrolls = Payroll::latest()->get();
    }

    public function createPayroll()
    {
        $this->validate([
            'payroll_period_start' => 'required|date',
            'payroll_period_end' => 'required|date|after_or_equal:payroll_period_start',
            'payment_date' => 'required|date',
        ]);

        DB::transaction(function () {
            $payroll = Payroll::create([
                'payroll_period_start' => $this->payroll_period_start,
                'payroll_period_end' => $this->payroll_period_end,
                'payment_date' => $this->payment_date,
                'notes' => $this->notes,
            ]);

            foreach (Employee::all() as $employee) {
                $base = $employee->base_salary;
                $allowance = $employee->allowances()->sum('amount');
                $deduction = $employee->deductions()->sum('amount');
                $gross = $base + $allowance;
                $tax = $gross * ($employee->tax_rate / 100);

                // Attendance-based deduction
                $attendancePenalty = $employee->getAttendancePenalty(
                    $this->payroll_period_start,
                    $this->payroll_period_end
                );

                $totalDeductions = $deduction + $attendancePenalty;

                $net = $gross - $tax - $totalDeductions;

                PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'employee_id' => $employee->id,
                    'basic_salary' => $base,
                    'total_allowance' => $allowance,
                    'gross_salary' => $gross,
                    'total_deductions' => $totalDeductions,
                    'total_taxes' => $tax,
                    'net_salary' => $net,
                    'payment_status' => 'unpaid'
                ]);
            }
        });

        session()->flash('message', 'Payroll berhasil dibuat.');
        $this->mount(); // refresh payroll list
    }

    public function showPayrollDetail($id)
    {
        $this->emit('showPayrollDetail', $id);
    }

    public function render()
    {
        return view('livewire.Payroll');
    }
}
