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
            'company_name' => 'Optitax’s Consultants', 
            'res_company_name' => 'optx', 
            'website_name' => 'optx.com',
            'phone' => '1234567890', 
            'address' => 'Hyderabad', 
            'gst_no' => '123456',
            'company_details' => 'Vision- To deliver best-in-class services with customized solutions at affordable prices

            Mission- To nurture a knowledge-building work culture by encouraging associates to grow on focussed forefronts
            
            Values- commitment, integrity',
            'logo' => 'logo.png',
        ]);
    }
}
