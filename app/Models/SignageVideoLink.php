<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignageVideoLink extends Model
{
    use HasFactory;
    protected $table='signage_video_links';
    protected $fillable=[
      'link_name',
      'isActive'
    ];

    
}
