<?php

use Illuminate\Database\Seeder;

class CompanyAndEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(App\Company::class, 10)->states('with_image')
            ->create()
            ->each(function ($company) {
                $company->employees()->saveMany(
                    factory(App\Employee::class, 10)->make([
                        'company_id' => null,
                    ])
                );
            });
    }
}
