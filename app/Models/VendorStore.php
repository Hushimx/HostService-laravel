<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorStore extends Model
{
    use HasFactory;

    protected $table = 'vendor_store';

    protected $fillable = ['vendorId', 'storeId'];

}
