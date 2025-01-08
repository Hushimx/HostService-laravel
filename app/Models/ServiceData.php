<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceData extends Model
{
  protected $table = 'services';
  protected $fillable = ['client_id', 'service_id', 'vendor_id', 'city_id', 'room_id', 'status', 'total'];

  public function service()
  {
    return $this->belongsTo(Service::class);
  }

  public function vendor()
  {
    return $this->belongsTo(Vendor::class);
  }

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public function room()
  {
    return $this->belongsTo(Room::class);
  }

}
