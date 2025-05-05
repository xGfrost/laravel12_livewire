<?php

namespace App\Livewire\Admin\Employees;

use App\Models\Designation;
use App\Models\Employee;
use Livewire\Component;

class Create extends Component
{
    public $employee;
    public $departments_id;

    public function rules()
    {
        return [
            'employee.name' => 'required|string|max:255',
            'employee.email' => 'required|email|max:255',
            'employee.phone' => 'required|string|max:15',
            'employee.address' => 'required|string|max:255',
            'employee.designation_id' => 'required|exists:departments,id',
        ];
    }

    public function mount()
    {
        $this->employee = new Employee();
    }

    public function save()
    {
        $this->validate();
        $this->employee->company_id = session('company_id');
        $this->employee->save();
        session()->flash('success', 'Employee created successfully.');
        return $this->redirectIntended(route('employees.index'));
    }
    public function render()
    {
        $designations = Designation::inCompany()->where('department_id', $this->departments_id)->get();
        return view('livewire.admin.employees.create', [
            'designations' => $designations,
            'departments' => Designation::inCompany()->get(),
        ]);
    }
}
