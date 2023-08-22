<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodiumPrsesntationImage extends Model
{
    use HasFactory;
    protected $table='podium_prsesntation_images';
    protected $fillable=[
      'image_id_one',
      'image_id_two',
      'image_id_three',
      'category',
      'is_active'
    ];

    public function podiumpresentation()
    {
        return $this->hasMany(PodiumPresentation::class, 'image_id_one')
                    ->orWhere('image_id_two','id')
                    ->orWhere('image_id_three','id');
    }
}
