<?php

namespace App\Livewire\Admin\Designations;

use App\Models\Designation;
use Livewire\Component;

class Edit extends Component
{
    public $designation;

    public function rules()
    {
        return [
            'designation.name' => 'required|string|max:255',
            'designation.department_id' => 'required|exists:departments,id'
        ];
    }

    public function mount($id)
    {
        $this->designation = Designation::find($id);
    }

    public function save()
    {
        $this->validate();
        $this->designation->company_id = session('company_id');
        $this->designation->save();
        session()->flash('success', 'Designation edited successfully.');
        return $this->redirectIntended(route('designations.index')); 
    }
    public function render()
    {
        return view('livewire.admin.designations.edit');
    }
}
