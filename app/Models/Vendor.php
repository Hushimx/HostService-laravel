<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}
