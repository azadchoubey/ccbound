<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
class UserSubscription extends Model
{
    use HasFactory;

    // protected $casts = [
    //     'end_date'  => 'date:Y-m-d',
    // ];

    public function company(){
        return $this->belongs(Company::class);
    }
}
