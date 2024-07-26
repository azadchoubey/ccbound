<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Company;
use App\Models\Enquiry;
use App\Models\Sale;
use App\Models\Product;
use App\Models\enquiryChat;
use App\Models\Payment;
use App\Models\Payouts;
use App\Models\Wallet;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    // use MustVerifyEmail;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'created_by',
        'referrer',
        'admin',
        'name',
        'email',
        'number',
        'password',
        'company_id',
        'address',
        'country',
        'state',
        'city',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected $with = [ 'company' ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        $url = env('APP_URL').'/storage/profile_photos/'.$this->profile_photo_path;
        return $url;
    }

    public function getCompanyAttribute()
    {
        return $this->company();
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function enquiryChats()
    {
        return $this->hasMany(EnquiryChat::class);
    }

    public function contacts(){
        return $this->belongsToMany(User::class,'user_contact','user_id','contact_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function payouts(){
        return $this->hasMany(Payout::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}
