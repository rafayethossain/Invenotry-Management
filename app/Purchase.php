<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product; 

class Purchase extends Model
{
    protected $guarded =[];

    //relation between product and purchase
    public function product() {
    	return $this->belongsTo(Product::class, 'product_id');
    }
}
