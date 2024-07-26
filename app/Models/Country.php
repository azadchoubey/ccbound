<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // public function state()
    // {
    //     return $this->hasOne(State::class);
    // }

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
