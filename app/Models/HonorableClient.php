<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HonorableClient extends Model
{
    use HasFactory;
    protected $table='honorable_clients';
    protected $fillable=[
      'title_id',
      'description',
      'image',
      'link',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
