<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'upi',
        'account_number',
        'account_branch',
        'ifsc_code',
        'gst_number',
        'pan_number',
        'aadhar_number',
    ];

    protected $with = ['user.wallet'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
