<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'customer';
    protected $fillable = ['firstname','lastname','image','email','telephone','password','status','creation','social_id'];

    const ACTIVE = 1;

    public static function getActivePluck() {
        return self::active()->get()->pluck('full_name', 'id');
    }

    public function review() {
        return $this->hasMany('App\Models\Review');
    }

    public function getFullNameAttribute(){
        return $this->firstname . ' ' . $this->lastname;
    }

    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }
}
