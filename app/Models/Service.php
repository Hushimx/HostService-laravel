<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = ['slug', 'name', 'description'];

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }
}
