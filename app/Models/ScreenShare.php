<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenShare extends Model
{
    use HasFactory;
    protected $table='screen_shares';
    protected $fillable=[
      'title_id',
      'description',
      'isActive'
    ];

    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
