<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $table='devices';
    protected $fillable=[
      'title_id',
      'subtitle_id',
      'image_id',
      'name',
      'isActive'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }

    public function subtitle()
    {
        return $this->belongsTo(subtitle::class);
    }

    public function deviceimage()
    {
        return $this->belongsTo(deviceimage::class,'image_id');
    }
}
