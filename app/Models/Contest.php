<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function isPending()
    {
        return $this->status == 0;
    }

    public function isStarted()
    {
        return $this->status == 1;
    }

    public function isEnded()
    {
        return $this->status == 2;
    }

    public function digitals()
    {
        return $this->belongsToMany('App\Models\DigitalShowImage', 'contest_star_relations', 'contest_id', 'digital_id')->withPivot('investment');
    }

    public function investors()
    {
        return $this->belongsToMany('App\Models\Seller', 'contest_star_relations', 'contest_id', 'investor_id')->withPivot('investment');
    }
}
