<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;
    protected $table='titles';
    protected $fillable=[
      'name',
      'description',
      'category',
      'isActive'
    ];


    public function csp()
    {
        return $this->hasMany(csp::class, 'title_id', 'id');
    }

    public function edu()
    {
        return $this->hasMany(Edu::class, 'header_title', 'id');
    }
}
