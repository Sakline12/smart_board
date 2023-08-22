<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTitle extends Model
{
  use HasFactory;
  protected $table = 'sub_titles';
  protected $fillable = [
    'name',
    'description',
    'category',
    'is_active'
  ];

  public function testimonial()
  {
    return $this->hasMany(testimonial::class, 'subtitle_id', 'id');
  }

  public function device()
  {
    return $this->hasOne(device::class, 'subtitle_id', 'id');
  }

  public function podiumpresentation()
  {
    return $this->hasOne(podiumpresentation::class, 'subtitle_id', 'id');
  }
}
