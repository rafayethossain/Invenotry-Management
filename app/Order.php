<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Product;
use App\Customer;

class Order extends Model
{
    protected $guarded =[];

    //relation between user and order
    public function user() {
        return $this->belongsTo(User::class, 'seller_id')->withTrashed();
    }

    //relation between customer and order
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    //relation between product and order
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
