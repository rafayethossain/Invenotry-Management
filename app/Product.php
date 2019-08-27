<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Order;
use App\SubCategory;
use App\Category;
use App\Purchase;
use App\Sale;
use App\DamagedProduct;
use App\ReturnedProduct;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    //relation between product and order
    public function order() {
        return $this->hasMany(Order::class);
    }

    //relation between product and sale
    public function sale() {
        return $this->hasMany(Sale::class);
    }

    //relation between product and damage
    public function damage() {
        return $this->hasMany(DamagedProduct::class);
    }

    //relation between product and return
    public function return() {
        return $this->hasMany(ReturnedProduct::class);
    }

    //relation between subcategory and category
    public function subcategory() {
    	return $this->belongsTo(SubCategory::class, 'subCategory_id')->withTrashed();
    }

    //relation between category and category
    public function category() {
    	return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    //relation between product and purchase
    public function purchase() {
        return $this->hasMany(Purchase::class);
    }
}
