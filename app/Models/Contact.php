<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table='contacts';
    protected $fillable=[
      'mail',
      'subject',
      'message',
      'is_active'
    ];

    
    public function title()
    {
        return $this->belongsTo(title::class);
    }
}
