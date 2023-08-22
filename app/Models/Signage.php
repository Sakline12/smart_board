<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signage extends Model
{
    use HasFactory;
    protected $table='signages';
    protected $fillable=[
      'title_id',
      'name',
      'is_active'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
