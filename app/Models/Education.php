<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $table='educations';
    protected $fillable=[
      'header_title',
      'heading_description',
      'image',
      'title',
      'description',
      'button_text',
      'button_link',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
