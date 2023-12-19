<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $adminRecords = [
            [
                'id' => 2,
                'name' => 'John',
                'type' => 'vendor',
                'vendor_id' => 1,
                'mobile' => '123456789',
                'email' => 'john@admin.com',
                'password' => bcrypt('password'),
                'image' => '',
                'status' => 0,
            ],


            ];

        Admin::insert($adminRecords);

    }
}
