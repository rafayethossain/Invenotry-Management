<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Customer;
use App\User;
use App\SubArea;

class Area extends Model
{
	use SoftDeletes;
    protected $guarded =[];

    //relation between area and subarea
    public function subarea() {
        return $this->hasMany(SubArea::class)->withTrashed();
    }

    //relation between area and customer
    public function customer() {
    	return $this->hasMany(Customer::class)->withTrashed();
    }

    //relation between area and user
    public function user() {
    	return $this->hasMany(User::class)->withTrashed();
    }
}
