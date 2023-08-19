<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignageSpecification extends Model
{
    use HasFactory;
    protected $table='signage_specifications';
    protected $fillable=[
      'title_id',
      'feature',
      'inch_86_ifp',
      'inch_75_ifp',
      'inch_65_ifp',
      'isActive'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
