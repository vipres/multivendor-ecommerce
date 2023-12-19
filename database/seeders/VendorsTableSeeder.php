<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id' => 1, 'name' => 'John', 'address' => '123 Main St', 'city' => 'New York', 'state' => 'NY', 'country' => 'USA', 'pincode' => '10001', 'mobile' => '123456789', 'email' => 'john@admin.com', 'status'=>0],
        ];
        Vendor::insert($vendorRecords);

    }
}
