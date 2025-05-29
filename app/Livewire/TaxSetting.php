<?php

namespace App\Livewire;

use App\Models\Tax;
use Livewire\Component;

class TaxSetting extends Component
{
    public $taxId = '';
    public $name;
    public $description;
    public $rate;
    public $threshold;

    public function render()
    {
        return view('livewire.admin.tax-setting', [
            'taxes' => Tax::orderBy('name')->get(),
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|unique:taxes,name,' . $this->taxId,
            'description' => 'nullable|string',
            'rate' => 'required|numeric',
            'threshold' => 'required|numeric',
        ]);

        Tax::updateOrCreate(
            ['id' => $this->taxId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'rate' => $this->rate,
                'threshold' => $this->threshold,
            ]
        );

        session()->flash('success', $this->taxId ? 'Tax updated successfully.' : 'New tax added successfully.');

        $this->reset(['taxId', 'name', 'description', 'rate', 'threshold']);
    }

    public function edit($id)
    {
        $tax = Tax::findOrFail($id);

        $this->taxId = $tax->id;
        $this->name = $tax->name;
        $this->description = $tax->description;
        $this->rate = $tax->rate;
        $this->threshold = $tax->threshold;
    }

    public function delete($id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();

        session()->flash('success', 'Tax deleted successfully.');

        $this->reset(['taxId', 'name', 'description', 'rate', 'threshold']);
    }
}
