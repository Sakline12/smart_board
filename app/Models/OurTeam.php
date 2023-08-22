<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    use HasFactory;
    protected $table='our_teams';
    protected $fillable=[
      'title_id',
      'name',
      'department',
      'designation',
      'image',
      'sequence',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
