<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestStarRelation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contest()
    {
        return $this->belongsTo('App\Models\Contest', 'contest_id', 'id');
    }

    public function star()
    {
        return $this->belongsTo('App\Models\Seller', 'star_id', 'id');
    }

    public function investor()
    {
        return $this->belongsTo('App\Models\Seller', 'investor_id', 'id');
    }
}
