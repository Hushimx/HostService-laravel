<?php
namespace App\Models;

use App\Models\City;
use App\Models\Store;
use App\Models\Product;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'vendors';

    protected $fillable = ['name', 'email', 'password', 'phoneNo', 'address', 'cityId'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vendor) {
            $vendor->password = Hash::make($vendor->password);
        });
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Many-to-Many relationship with Store
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'vendor_store', 'vendorId', 'storeId');
    }

}
