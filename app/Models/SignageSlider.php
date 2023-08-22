<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignageSlider extends Model
{
    use HasFactory;
    protected $table='signage_sliders';
    protected $fillable=[
      'title_id',
      'image_one',
      'image_two',
      'image_three',
      'is_active'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
