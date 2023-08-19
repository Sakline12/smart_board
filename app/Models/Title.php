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

    public function about(){
        return $this->hasMany(about::class,'header_title','id');
    }

    public function interactiveslider(){
        return $this->hasOne(interactiveslider::class,'title_id','id');
    }

    public function device(){
        return $this->hasOne(device::class,'title_id','id');
    }

    public function iteractivespecification(){
        return $this->hasOne(iteractivespecification::class,'title_id','id');
    }

    public function podiumintroduction(){
        return $this->hasOne(podiumintroduction::class,'title_id','id');
    }
    
    public function screenshare(){
        return $this->hasOne(screenshare::class,'title_id','id');
    }

    public function podium(){
        return $this->hasOne(podium::class,'title_id','id');
    }

    public function wirelessdevice(){
        return $this->hasOne(wirelessdevice::class,'title_id','id');
    }

    public function anotation(){
        return $this->hasOne(anotation::class,'title_id','id');
    }

    public function podiumfeature(){
        return $this->hasOne(podiumfeature::class,'title_id','id');
    }

    
    public function podiumpresentation(){
        return $this->hasOne(podiumpresentation::class,'title_id','id');
    }

    public function signageintroduction(){
        return $this->hasOne(signageintroduction::class,'title_id','id');
    }

    public function signage(){
        return $this->hasOne(signage::class,'title_id','id');
    }

    public function signageslider(){
        return $this->hasOne(signageslider::class,'title_id','id');
    }

    
    public function signagespecification(){
        return $this->hasOne(signagespecification::class,'title_id','id');
    }
    

    public function contactintroduction(){
        return $this->hasOne(contactintroduction::class,'title_id','id');
    }
}
