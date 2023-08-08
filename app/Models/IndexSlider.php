<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexSlider extends Model
{
    use HasFactory;
    protected $table='indexsliders';
    protected $fillable=[
      'image',
      'title',
      'content',
      'button_text',
      'isActive'
    ];
}
