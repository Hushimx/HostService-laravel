<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreSection extends Model
{
  use HasFactory;

  protected $table = 'store_sections';

  protected $fillables = ['name'];

  public function stores() {
    return $this->belongsTo(Store::class, 'sectionId');
  }
}
