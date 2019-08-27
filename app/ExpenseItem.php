<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Expense;

class ExpenseItem extends Model
{
    protected $guarded =[];

    //relation between expense and expenseitem
    public function expense() {
        return $this->hasMany(Expense::class);
    }
}
