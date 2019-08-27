<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Role;
use App\Area;
use App\SubArea;
use App\Order;
use App\Sale;
use App\Loan;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes, EntrustUserTrait {

        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded =[];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //relation between user and area
    public function area() {
        return $this->belongsTo(Area::class, 'area_id')->withTrashed();
    }

    //relation between user and area
    public function subarea() {
        return $this->belongsTo(SubArea::class, 'subArea_id')->withTrashed();
    }

    //relation between user and order
    public function order() {
        return $this->hasMany(Order::class);
    }

    //relation between user and loan
    public function loan() {
        return $this->hasMany(Loan::class);
    }

    //relation between user and sale
    public function sale() {
        return $this->hasMany(Sale::class);
    }
}
