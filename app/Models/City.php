<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = ['name', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // has Many city
    public function deliveryOrders() {
        return $this->hasMany(DeliveryOrder::class, 'cityId');
    }
}
