<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalImageComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function image()
    {
        return $this->belongsTo('App\Models\DigitalShowImage', 'image_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\Seller', 'user_id', 'id');
    }
}
