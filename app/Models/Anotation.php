<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anotation extends Model
{
    use HasFactory;
    protected $table='anotations';
    protected $fillable=[
      'title_id',
      'sub_title',
      'field_one',
      'field_two',
      'field_three',
      'background_image',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
