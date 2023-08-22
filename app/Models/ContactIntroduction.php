<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactIntroduction extends Model
{
    use HasFactory;
    protected $table='contact_introductions';
    protected $fillable=[
      'title_id',
      'background_image',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
