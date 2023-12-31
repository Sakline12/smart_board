<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=[
      'title_id',
      'product_image',
      'background_img',
      'is_active'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
