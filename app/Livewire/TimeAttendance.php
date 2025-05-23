<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Overtime;
use App\Models\Employee;
use Carbon\Carbon;

class TimeAttendance extends Component
{
     public $dateFilter;
    public $attendances = [];
    public $overtimes = [];

    public $employee_id, $overtime_date, $start_time, $end_time, $reason, $duration_hours;
    public $editMode = false, $overtime_id;

    public function mount()
    {
        $this->dateFilter = now()->format('Y-m-d');
        $this->loadData();
    }

    public function loadData()
    {
        $this->attendances = Attendance::where('attendance_date', $this->dateFilter)->get();
        $this->overtimes = Overtime::where('overtime_date', $this->dateFilter)->get();
    }

    public function updated($property)
    {
        if (in_array($property, ['start_time', 'end_time'])) {
            $this->calculateDuration();
        }
    }

    public function calculateDuration()
    {
        if ($this->start_time && $this->end_time) {
            $start = Carbon::parse($this->start_time);
            $end = Carbon::parse($this->end_time);
            $this->duration_hours = $end->diffInMinutes($start) / 60;
        }
    }

    public function saveOvertime()
    {
        $this->validate([
            'employee_id' => 'required',
            'overtime_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'duration_hours' => 'required|numeric|min:0.1',
            'reason' => 'nullable|string',
        ]);

        if ($this->editMode) {
            Overtime::find($this->overtime_id)->update($this->only([
                'employee_id', 'overtime_date', 'start_time', 'end_time', 'duration_hours', 'reason'
            ]));
        } else {
            Overtime::create($this->only([
                'employee_id', 'overtime_date', 'start_time', 'end_time', 'duration_hours', 'reason'
            ]));
        }

        $this->resetForm();
        $this->loadData();
    }

    public function edit($id)
    {
        $overtime = Overtime::findOrFail($id);
        $this->fill($overtime->toArray());
        $this->editMode = true;
        $this->overtime_id = $id;
    }

    public function delete($id)
    {
        Overtime::findOrFail($id)->delete();
        $this->loadData();
    }

    public function resetForm()
    {
        $this->reset(['employee_id', 'overtime_date', 'start_time', 'end_time', 'duration_hours', 'reason', 'editMode', 'overtime_id']);
    }

    public function render()
    {
        return view('livewire.time-attendance', [
            'employees' => Employee::all(),
        ]);
    }
}