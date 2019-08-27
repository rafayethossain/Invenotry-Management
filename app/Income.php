<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Customer;

class Income extends Model
{
	use SoftDeletes;
    protected $guarded =[];

    //relation between customer and area
    public function customer() {
    	return $this->belongsTo(Customer::class, 'customer_id')->withTrashed();
    }
}
