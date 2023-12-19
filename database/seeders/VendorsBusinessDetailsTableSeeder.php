<?php

namespace Database\Seeders;


use App\Models\VendorsBusinessDetail;

use Illuminate\Database\Seeder;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $vendorRecords = [
           [
               'id' => 1,
               'vendor_id' => 1,
               'shop_name' => 'John Electronic Shop',
                'shop_address' => 'Avda Constitución, 47',
                'shop_city' => 'Mérida',
                'shop_state' => 'Badajoz',
                'shop_country' => 'Spain',
                'shop_pincode' => '06800',
                'shop_mobile' => '123456789',
                'shop_website' => 'shop1demo.com',
                'shop_email' => 'john@admin.com',
                'address_proof' => 'Passport',
                'address_proof_image'=> 'test.jpg',
                'business_license_number' => 'B06857498',
                'gst_number' => 'ES4545445',
                'pan_number' => '454445454574575274',

           ]
         ];

         VendorsBusinessDetail::insert($vendorRecords);

    }
}
