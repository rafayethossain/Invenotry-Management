<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Area;
use App\User;

class SubArea extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    //relation between subarea and area
    public function area() {
    	return $this->belongsTo(Area::class, 'area_id')->withTrashed();
    }

    //relation between subarea and user
    public function user() {
    	return $this->hasMany(User::class)->withTrashed();
    }
}
