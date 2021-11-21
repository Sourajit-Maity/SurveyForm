<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::create([
            'company_name' => 'Ira India Pvt Ltd', 
            'res_company_name' => 'ira', 
            'website_name' => 'ira.com',
            'phone' => '1234567890', 
            'address' => 'Hyderabad', 
            'gst_no' => '123456',
            'company_details' => 'ira details',
            'logo' => 'logo.png',
        ]);
    }
}
