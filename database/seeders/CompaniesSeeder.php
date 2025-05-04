<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'google',
                'email' => 'contact@google.com',
                'website'=> 'https://www.google.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'apple',
                'email' => 'contact@apple.com',
                'website'=> 'https://www.apple.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'microsoft',
                'email' => 'contact@microsoft.com',
                'website'=> 'https://www.microsoft.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'amazon',
                'email' => 'contact@amazon.com',
                'website'=> 'https://www.amazon.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        foreach (Company::all() as $key => $company){
            $company->users()->attach(1);
        }
    }
}
