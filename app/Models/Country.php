<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{

    use SoftDeletes;
    protected $table = 'country';
    protected $fillable = ['name','iso_code_2','iso_code_3','address_format','postcode_required','status'];

    const ACTIVE = 1;

    public static function getActivePluck() {
        return self::select('name','id')->active()->pluck('name','id');
    }
    public function scopeActive($query) {
        return $query->where('status', self::ACTIVE);
    }
}
