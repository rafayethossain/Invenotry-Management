<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\Product;

class ReturnedProduct extends Model
{
    protected $guarded =[];

    //relation between product and return
    public function product() {
    	return $this->belongsTo(Product::class, 'product_id');
    }

    //relation between product and return
    public function customer() {
    	return $this->belongsTo(Customer::class, 'customer_id');
    }
}
