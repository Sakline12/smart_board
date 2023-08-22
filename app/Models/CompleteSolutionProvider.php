<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteSolutionProvider extends Model
{
    use HasFactory;
    protected $table='complete_solution_providers';
    protected $fillable=[
      'title_id',
      'image',
      'subtitle',
      'description',
      'category',
      'button_text',
      'button_link',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
