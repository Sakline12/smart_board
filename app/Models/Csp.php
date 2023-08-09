<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Csp extends Model
{
    use HasFactory;
    protected $table='csps';
    protected $fillable=[
      'title_id',
      'image',
      'subtitle',
      'description',
      'category',
      'button_text',
      'button_link',
      'isActive'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }


}
