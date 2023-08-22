<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodiumIntroduction extends Model
{
    use HasFactory;
    protected $table='podium_introductions';
    protected $fillable=[
      'title_id',
      'sub_title',
      'description_one',
      'description_two',
      'button_text_one',
      'button_text_two',
      'button_link_one',
      'button_link_two',
      'is_active'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
