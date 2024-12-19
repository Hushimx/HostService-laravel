<?php
namespace App\Models;

use App\Models\City;
use App\Models\Vendor;
use App\Models\ServiceData;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  protected $table = 'city_service_vendors';
  protected $fillable = ['ServicesData'];

  public function service()
  {
    return $this->hasOne(ServiceData::class, 'id');
  }

  // one vendor many services
  public function vendor()
  {
    return $this->belongsTo(Vendor::class, 'vendorId');
  }

  // one city many services
  public function city()
  {
    return $this->belongsTo(City::class, 'cityId');
  }

}
