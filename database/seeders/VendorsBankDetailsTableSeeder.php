<?php

namespace Database\Seeders;

use App\Models\VendorsBankDetail;
use Illuminate\Database\Seeder;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $vendorRecords = [
              [
                'id' => 1,
                'vendor_id' => 2,
                'account_holder_name' => 'John Smith',
                'bank_name' => 'ICICI Bank',
                'account_number' => '123456789',
                'bank_ifsc_code' => 'ICIC0000001',
              ]
            ];

            VendorsBankDetail::insert($vendorRecords);
    }
}
