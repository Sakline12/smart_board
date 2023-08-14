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


    public function product()
    {
        return $this->hasMany(product::class, 'title_id', 'id');
    }

    public function csp()
    {
        return $this->hasMany(csp::class, 'title_id', 'id');
    }

    public function education()
    {
        return $this->hasMany(education::class, 'header_title', 'id');
    }

    public function featureproduct()
    {
        return $this->hasMany(FeatureProduct::class, 'title_id', 'id');
    }

    public function conference()
    {
        return $this->hasMany(Conference::class, 'title_id', 'id');
    }

    public function honorableclient()
    {
        return $this->hasMany(honorableclient::class, 'title_id', 'id');
    }

    public function ourteam()
    {
        return $this->hasMany(ourteam::class, 'title_id', 'id');
    }

    public function casestudy(){
        return $this->hasOne(casestudy::class, 'title_id', 'id');
    }

    public function testimonial(){
        return $this->hasMany(testimonial::class,'title_id','id');
    }

    public function panel(){
        return $this->hasMany(panel::class,'title_id','id');
    }
}
