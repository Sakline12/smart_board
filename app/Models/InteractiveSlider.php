<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteractiveSlider extends Model
{
    use HasFactory;
    protected $table='interactive_sliders';
    protected $fillable=[
      'title_id',
      'subtitle',
      'background_image',
      'image',
      'icon_link',
      'isActive'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
