<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceImage extends Model
{
    use HasFactory;
    protected $table='device_images';
    protected $fillable=[
      'image',
      'category',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class,'image_id','id');
    }


    


}
