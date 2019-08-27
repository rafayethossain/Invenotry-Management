<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class DamagedProduct extends Model
{
    protected $guarded =[];

    //relation between product and damage
    public function product() {
    	return $this->belongsTo(Product::class, 'product_id');
    }
}
