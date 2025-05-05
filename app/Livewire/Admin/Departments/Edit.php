<?php

namespace App\Livewire\Admin\Departments;

use App\Models\Department;
use Livewire\Component;

class Edit extends Component
{
    public $department;

    public function rules()
    {
        return [
            'department.name' => 'required|string|max:255',
        ];
    }

    public function mount($id)
    {
        $this->department = Department::find($id);
    }

    public function save()
    {
        $this->validate();
        $this->department->company_id = session('company_id');
        $this->department->save();
        session()->flash('success', 'Department edited successfully.');
        return $this->redirectIntended(route('departments.index'));
    }

    public function render()
    {
        return view('livewire.admin.departments.edit');
    }
}
