<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $table='testimonials';
    protected $fillable=[
      'title_id',
      'subtitle_id',
      'image',
      'name',
      'designation',
      'review',
      'feed_back',
      'is_active'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }

    public function subtitle()
    {
        return $this->belongsTo(subtitle::class);
    }
}
