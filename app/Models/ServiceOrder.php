<?php

namespace App\Models;

use App\Models\City;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceOrder extends Model
{
  use HasFactory;

  protected $table = 'service_orders';

  public function city() {
    return $this->belongsTo(City::class, 'cityId');
  }

  public function service() {
    return $this->belongsTo(Service::class, 'serviceId');
  }

  // Each service order belongs to a room
  public function room()
  {
    return $this->belongsTo(Room::class, 'roomId');
  }

}
