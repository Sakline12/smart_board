<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodiumPresentation extends Model
{
    use HasFactory;
    protected $table='podium_presentations';
    protected $fillable=[
      'title_id',
      'subtitle_id',
      'image_one',
      'image_two',
      'image_three',
      'name',
      'is_active'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }

    public function subtitle()
    {
        return $this->belongsTo(subtitle::class);
    }

    // public function imageOne()
    // {
    //     return $this->belongsTo(PodiumPrsesntationImage::class, 'image_id_one');
    // }
    
    // public function imageTwo()
    // {
    //     return $this->belongsTo(PodiumPrsesntationImage::class, 'image_id_two');
    // }
    
    // public function imageThree()
    // {
    //     return $this->belongsTo(PodiumPrsesntationImage::class, 'image_id_three');
    // }

}
