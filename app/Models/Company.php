<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Enquiry;
use App\Models\Sale;
use App\Models\Product;
use App\Models\UserSubscription;

class Company extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        'logo_url',
        'status',
    ];

    protected $with = [
        'subscription'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function enquiries()
    {
        return $this->hasManyThrough(Enquiry::class, User::class);
    }

    public function sales()
    {
        return $this->hasManyThrough(Sale::class, User::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, User::class);
    }

    public function subscription(){
        return $this->hasOne(UserSubscription::class)->latest();
    }

    public function getLogoUrlAttribute()
    {
        $url = env('APP_URL').'/storage/company_logo/'.$this->logo;
        return $url;
    }

    public function getStatusAttribute(){
        if($this->subscription){
            if($this->subscription->subscription == '#SUB000000' && $this->subscription->end_date >= date('Y-m-d')){
                return 'Trail period';
            } else if($this->subscription->subscription == '#SUB000000' && $this->subscription->end_date < date('Y-m-d')){
                return 'Trail period Expired';
            }else if($this->subscription->subscription != '#SUB000000' && $this->subscription->end_date >= date('Y-m-d')){
                return 'Subscribed';
            }else{
                return 'Expired';
            }
        }
    }
}
