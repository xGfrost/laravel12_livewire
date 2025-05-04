<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
           $departments= $company->departments()->createMany([
                [
                    'name' => 'HR',
                ],
                [
                    'name' => 'IT',
                ],
                [
                    'name' => 'Finance',
                ],
            ]);
        }

        foreach ($departments as $department) {
            switch ($department->name) {
                case 'HR':
                    $designations = [
                        'HR Manager',
                        'HR Executive',
                        'HR Intern',
                    ];
                    break;

                case 'IT':
                    $designations = [
                        'Software Engineer',
                        'System Administrator',
                        'IT Support',
                    ];
                    break;

                case 'Finance':
                    $designations = [
                        'Accountant',
                        'Financial Analyst',
                        'Finance Intern',
                    ];
                    break;

                default:
                    $designations = [];
                    break;
            }
            foreach ($designations as $designation) {
                $department->designations()->create([
                    'name' => $designation,
                ]);
            }
        }
    }
}
