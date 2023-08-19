<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodiumFeature extends Model
{
    use HasFactory;
    protected $table='podium_features';
    protected $fillable=[
      'title_id',
      'description',
      'background_image',
      'isActive'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
