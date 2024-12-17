<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'Products_Category';

    protected $fillable = ['name', 'storeId'];

    // Define the one-to-many relationship with Product
    public function products()
    {
        return $this->hasMany(Product::class, 'categoryId');
    }
}
