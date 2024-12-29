<?php

namespace App\Models;

use App\Models\City;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
  use HasFactory;

  protected $table = 'stores';

  protected $fillable = ['name', 'imageUrl', 'bannerUrl', 'description', 'slug', 'type'];

  // Many-to-Many relationship with Vendor
  public function vendors()
  {
    return $this->belongsTo(Vendor::class, 'storeId');
  }

  public function city()
  {
    return $this->hasOne(City::class, 'id');
  }

  public function products()
  {
    return $this->hasMany(Product::class, 'id');
  }



}
