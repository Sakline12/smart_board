<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodiumPresentation extends Model
{
    use HasFactory;
    protected $table='podium_prsentations';
    protected $fillable=[
      'title_id',
      'subtitle_id',
      'image_id_one',
      'image_id_two',
      'image_id_three',
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

    public function imageOne()
    {
        return $this->belongsTo(PodiumPrsesntationImage::class, 'image_id_one');
    }
    
    public function imageTwo()
    {
        return $this->belongsTo(PodiumPrsesntationImage::class, 'image_id_two');
    }
    
    public function imageThree()
    {
        return $this->belongsTo(PodiumPrsesntationImage::class, 'image_id_three');
    }

}
