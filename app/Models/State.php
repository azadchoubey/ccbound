<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // public function city()
    // {
    //     return $this->hasOne(City::class);
    // }
    
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
