<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WirelessDevice extends Model
{
    use HasFactory;
    protected $table='wireless_devices';
    protected $fillable=[
      'title_id',
      'image_one',
      'image_two',
      'image_three',
      'isActive'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
