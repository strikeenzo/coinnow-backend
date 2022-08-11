<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
//customer
    use SoftDeletes;
    protected $table = 'review';
    protected $fillable = ['customer_id','text','rating','status'];


    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }

//    public function getFullNameAttribute() {
//        dd($this);
//        return $this->firstname.' '.$this->lastname;
//    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }


}
