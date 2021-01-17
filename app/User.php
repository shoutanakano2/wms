<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Log;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //ユーザーが持つWarehousesの取得
    public function warehouses(){
        Log::debug('ユーザーがもつWarehouses情報の取得');
        return $this->hasMany(Warehouse::class);
    }
    //ユーザーが持つitemsの取得
    public function items(){
        Log::debug('ユーザーが持つitems情報の取得');
        return $this->hasMany(Item::class);
    }
    //ユーザーが持つcustomersの取得
    public function customers(){
        Log::debug('ユーザーが持つcustomers情報の取得');
        return $this->hasMany(Customer::class);
    }
}
