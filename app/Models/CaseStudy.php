<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use HasFactory;
    protected $table='case_studies';
    protected $fillable=[
      'title_id',
      'title',
      'description',
      'isActive'
    ];

    
    public function title()
    {
        return $this->belongsTo(Title::class);
    }
}
