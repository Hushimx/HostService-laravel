<?php

namespace App\Models;

use App\Models\City;
use App\Models\Vendor;
use App\Models\StoreSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
  use HasFactory;

  protected $table = 'stores';

  protected $fillable = ['name', 'imageUrl', 'bannerUrl', 'description', 'slug', 'type', 'vendorId'];

  const CREATED_AT = 'createdAt'; // If your `created_at` column is also camelCase
  const UPDATED_AT = 'updatedAt';

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

  public function section() {
    return $this->hasOne(StoreSection::class, 'id');
  }



}
