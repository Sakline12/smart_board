<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteractiveVideoLink extends Model
{
    use HasFactory;
    protected $table='interactive_video_links';
    protected $fillable=[
      'link',
      'name',
      'category',
      'isActive'
    ];
}
