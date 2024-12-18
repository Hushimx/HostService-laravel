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
    public function deliveryOrder() {
        return $this->hasOne(DeliveryOrder::class, 'orderId');
    }

    // realtion
    public function product() {
        return $this->hasOne(Product::class, 'productId');
    }
}
