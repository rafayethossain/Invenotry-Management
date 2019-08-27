<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;
use App\Product;

class SubCategory extends Model
{
	use SoftDeletes;
    protected $guarded =[];

    //relation between subcategory and category
    public function category() {
    	return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    //relation between product and subcategory
    public function product() {
        return $this->hasMany(Product::class)->withTrashed();
    }
}
