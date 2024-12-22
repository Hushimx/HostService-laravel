<?php

namespace App\Models;

use App\Models\DeliveryOrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name', 'price', 'categoryId', 'aproved', 'image', 'vendorId', 'cityId', 'storeId'];

    // Override the updated_at column name
    const UPDATED_AT = 'updatedAt';

    // Override the created_at column name (optional)
    const CREATED_AT = 'createdAt';

    // Define the inverse relationship to ProductCategory
    public function category()
    {
      return $this->belongsTo(ProductCategory::class, 'categoryId');
    }

    // realtion - one Product many DeliveryOrderItem
    public function deliveryOrderItems() {
        return $this->hasMany(DeliveryOrderItem::class, 'productId');
    }
}
