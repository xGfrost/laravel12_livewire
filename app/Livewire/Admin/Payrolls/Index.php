<?php

namespace App\Livewire\Admin\Payrolls;

use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $monthYear;

    public function rules()
    {
        return[
            'monthYear' => 'required',
        ];
    }

    public function generatePayroll()
    {
        $this->validate();
        $date = Carbon::parse($this->monthYear);
        if(Payroll::inCompany()->where('month_year', $date->format('Y-m'))->exists()){
            throw ValidationException::withMessages([
                'monthYear' => 'Payroll for this month has already been generated.',
            ]);
        }else{
            $payroll = new Payroll();
            $payroll->month = $date->format('m');
            $payroll->year = $date->format('Y');
            $payroll->company_id = session('company_id');
            $payroll->save();
            foreach(Employee::inCompany()->get() as $employee){
                $contract = $employee->getActiveContract($date->startOfMonth()->toDateString(), $date->endOfMonth()->toDateString());
                if($contract){
                    $employee->basic_salary = $contract->basic_salary;
                $payroll->salaries()->create(
                    [
                        'employee_id' => $employee->id,
                        'gross_salary' => $contract->getTotalEarnings($date->format('Y-m')),
                    ]
                );
            }else{
                $payroll->employees()->attach($employee->id, ['basic_salary' => 0]);
            }
        }
        session()->flash('success', 'Payroll updated successfully.');
    }

}

    public function updatePayroll($id)
    {
        $payroll = Payroll::inCompany()->find($id);
        $payroll->salaries->delete();
        foreach(Employee::inCompany()->get() as $employee){
            $contract = $employee->getActiveContract($payroll->start_date, $payroll->end_date);
            if($contract){
                $employee->basic_salary = $contract->basic_salary;
                $payroll->salaries()->create(
                    [
                        'employee_id' => $employee->id,
                        'gross_salary' => $contract->getTotalEarnings($payroll->month_year),
                    ]
                );
            }else{
                $payroll->employees()->attach($employee->id, ['basic_salary' => 0]);
            }
        }
        session()->flash('success', 'Payroll updated successfully.');
    }
    public function render()
    {
        return view('livewire.admin.payrolls.index', [
            'payrolls' => Payroll::inCompany()->orderBy('year', 'desc')->orderBy('month', 'desc')->paginate(5),
        ]);
    }
}
