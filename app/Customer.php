<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Order;
use App\Income;
use App\Sale;
use App\ReturnedProduct;

class Customer extends Model
{
    use SoftDeletes;

    protected $guarded =[];

    //relation between customer and area
    public function area() {
    	return $this->belongsTo(Area::class, 'area_id')->withTrashed();
    }

    //relation between customer and order
    public function order() {
        return $this->hasMany(Order::class);
    }

    //relation between customer and return
    public function return() {
        return $this->hasMany(ReturnedProduct::class);
    }

    //relation between customer and sale
    public function sale() {
        return $this->hasMany(Sale::class);
    }

    //relation between customer and income
    public function income() {
        return $this->hasMany(Income::class)->withTrashed();
    }
}
