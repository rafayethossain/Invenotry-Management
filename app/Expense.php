<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ExpenseItem;

class Expense extends Model
{
	use SoftDeletes;
    protected $guarded =[];

    //relation between expenseitem and expense
    public function expenseitem() {
        return $this->belongsTo(ExpenseItem::class, 'expense_item_id');
    }
}
