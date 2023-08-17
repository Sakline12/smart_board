<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podium extends Model
{
    use HasFactory;
    protected $table='podiums';
    protected $fillable=[
      'title_id',
      'description',
      'background_image',
      'image',
      'isActive'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
