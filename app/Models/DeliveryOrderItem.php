<?php

namespace App\Models;

use App\Models\Vendor;
use App\Models\Product;
use App\Models\DeliveryOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrderItem extends Model
{
    use HasFactory;

    protected $table = 'delivery_order_items';

    // relation - one vendor many delivery_order_items
    public function vendor() {
      return $this->hasOne(Vendor::class, 'vendorId');
    }

    // realtion - one deliveryOrder many delivery_order_items
    public function deliveryOrder()
    {
      return $this->belongsTo(DeliveryOrder::class, 'orderId', 'id');
    }


    // realtion
    public function product() {
      return $this->hasOne(Product::class, 'id', 'productId');
    }

    public function city()
    {
      return $this->hasOneThrough(
        City::class,
        DeliveryOrder::class,
        'id',         // Foreign key on delivery_order_items table (deliveryOrderId)
        'id',         // Foreign key on cities table (id of the city)
        'orderId',    // Local key on delivery_order_items table
        'cityId'      // Local key on delivery_orders table
      );
    }


}
