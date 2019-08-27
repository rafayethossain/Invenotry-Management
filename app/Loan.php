<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Loan extends Model
{
    protected $guarded =[];

    //relation between user and loan
    public function user() {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
