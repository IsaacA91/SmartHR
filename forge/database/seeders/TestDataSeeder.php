<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
    

        // Create a test admin
        Admin::create([
            'adminID' => 'A001',
            'firstName' => 'Test',
            'lastName' => 'Admin',
            'companyID' => 'C001',
            'password' => 'password123' // Will be automatically hashed by the model
        ]);
    }
}