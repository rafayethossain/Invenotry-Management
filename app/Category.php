<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\SubCategory;
use App\Product;

class Category extends Model
{
	use SoftDeletes;
    protected $guarded =[];

    //relation between category and subcategory
    public function subcategory() {
    	return $this->hasMany(SubCategory::class)->withTrashed();
    }

    //relation between product and category
    public function product() {
        return $this->hasMany(Product::class)->withTrashed();
    }
}
