<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edu extends Model
{
    use HasFactory;
    protected $table='edus';
    protected $fillable=[
      'header_title',
      'heading_description',
      'image',
      'title',
      'description',
      'button_text',
      'button_link',
      'isActive'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
