<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignageIntroduction extends Model
{
    use HasFactory;
    protected $table='signage_introductions';
    protected $fillable=[
      'title_id',
      'header',
      'header_link',
      'image',
      'background_image',
      'is_active'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
