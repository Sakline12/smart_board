<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $table='designations';
    protected $fillable=[
       'title'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'designation_id', 'id');
    }
}
