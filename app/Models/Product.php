<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name', 'price', 'categoryId', 'image', 'vendorId', 'cityId', 'storeId'];

    // Define the inverse relationship to ProductCategory
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'categoryId');
    }
}
