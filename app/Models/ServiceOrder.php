<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
