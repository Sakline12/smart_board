<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureProduct extends Model
{
    use HasFactory;
    protected $table='feature_products';
    protected $fillable=[
      'title_id',
      'description',
      'master_image',
      'left_image',
      'right_image',
      'caption',
      'button_text',
      'button_link',
      'isActive'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
