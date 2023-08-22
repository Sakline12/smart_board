<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteractiveSpecification extends Model
{
    use HasFactory;
    protected $table='interactive_specifications';
    protected $fillable=[
      'title_id',
      'feature',
      'inch_86_ifp',
      'inch_75_ifp',
      'inch_65_ifp',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
