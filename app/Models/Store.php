<?php

namespace App\Models;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'imageUrl', 'description', 'slug'];

    // Define the many-to-many relationship
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_store');
    }
}
