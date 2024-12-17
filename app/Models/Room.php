<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $fillable = ['room_number', 'type', 'hotel_id'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
