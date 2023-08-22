<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $table='abouts';
    protected $fillable=[
      'header_title',
      'background_image',
      'question',
      'description',
      'image',
      'button_text',
      'button_link',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class,'header_title');
    }
}
