<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Product extends Model
{
    use HasFactory;

    protected $appends = [
        'structure_url',
        'docs_url',
        'location',
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStructureUrlAttribute()
    {
        if($this->structure) {
            $url = env('APP_URL').'/storage/product_structure/'.$this->structure;
        } else {
            $url = env('APP_URL').'/assests/images/no-image.jpg';
        }
        return $url;
    }

    public function getDocsUrlAttribute()
    {
        $url = env('APP_URL').'/storage/product_docs/'.$this->docs;
        return $url;
    }

    public function getUserAttribute(){
        return $this->user();
    }

    public function staff(){
        return $this->belongsToMany(User::class,'product_staff','product_id','user_id');
    }

    public function getLocationAttribute(){
        if($this->city){
            $city = City::find($this->city);
            return $city?->name;
        }
        else if($this->state){
            $state = State::find($this->state);
            return $state?->name;
        }else{
            $country = Country::find($this->country);
            return $country?->name;
        }
    }
}
