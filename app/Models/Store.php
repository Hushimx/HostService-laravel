<?php

namespace App\Models;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';

    protected $fillable = ['name', 'imageUrl', 'description', 'slug'];

    // Many-to-Many relationship with Vendor
    public function vendors()
    {
      return $this->belongsTo(Vendor::class, 'storeId');
    }

}
