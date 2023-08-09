<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexSlider extends Model
{
    use HasFactory;
    protected $table='index_sliders';
    protected $fillable=[
      'image',
      'title',
      'content',
      'button_text',
      'isActive',
      'button_link'
    ];
}
