<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;
    protected $table='conferences';
    protected $fillable=[
      'title_id',
      'master_image',
      'sub_image1',
      'sub_image2',
      'sub_image3',
      'sub_image4',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
