<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'type',
        'vendor_id',
        'mobile',
        'email',
        'password',
        'image',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function vendorPersonal(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendorBussiness(){
        return $this->belongsTo(VendorsBusinessDetail::class, 'vendor_id');
    }

    public function vendorBank(){
        return $this->belongsTo(VendorsBankDetail::class, 'vendor_id');
    }
}
