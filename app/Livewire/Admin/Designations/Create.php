<?php

namespace App\Livewire\Admin\Designations;

use App\Models\Designation;
use Livewire\Component;

class Create extends Component
{
    public $designation;

    public function rules()
    {
        return [
            'designation.name' => 'required|string|max:255|unique:designations,name',
            'designation.department_id' => 'required|exists:departments,id',
        ];
    }

    public function mount()
    {
        $this->designation = new Designation();
    }

    public function save()
    {
        $this->validate();
        $this->designation->company_id = session('company_id');
        $this->designation->save();
        session()->flash('success', 'Designation created successfully.');
        return $this->redirectIntended(route('designations.index'));
    }
    
    public function render()
    {
        return view('livewire.admin.designations.create');
    }
}
