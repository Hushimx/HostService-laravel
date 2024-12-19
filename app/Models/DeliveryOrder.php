<?php

namespace App\Models;

use App\Models\City;
use App\Models\DeliveryOrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $table = 'delivery_orders';

    // realtion - one deliveryOrder many delivery_order_items
    public function deliveryOrderItems() {
        return $this->hasMany(DeliveryOrderItem::class, 'orderId');
    }

    // gets all deliveryOrderItems where vendore id = user id
    public function deliveryOrderItemsVendor()
    {
        return $this->hasMany(DeliveryOrderItem::class, 'orderId', 'id')
            ->where('vendorId', Auth::guard('vendors')->user()->id);
    }

    // has one city
    public function city() {
        return $this->hasOne(City::class, 'id');
    }

}
