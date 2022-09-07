<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'seller';
    protected $fillable = ['user_id', 'firstname', 'lastname', 'email', 'telephone','password', 'store_name', 'balance', 'power', 'status'];
    protected $casts = [
        'balance' => 'float',
        'power' => 'integer',
    ];
    const ACTIVE = 1;

    public static function getActivePluck() {
        return self::active()->get()->pluck('full_name', 'id');
    }

    public function getFullNameAttribute(){
        return $this->firstname . ' ' . $this->lastname;
    }

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }

    public function product() {
        return $this->hasMany('App\Models\Product', 'seller_id', 'id');
    }

    public function notification() {
        return $this->hasMany('App\Models\Notification', 'seller_id', 'id');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order', 'seller_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_seller_relations', 'seller_id', 'product_id')->withPivot('sale_date', 'sell_date', 'sale', 'quantity', 'id', 'updated_at', 'created_at');
    }
}
