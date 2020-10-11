<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    protected $fillable=['user_id','item_code','item_name','sell_price','purchase_price','deleted_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function haved(){
        return $this->belongsToMany(Warehouse::class,'stocks','item_id','warehouse_id')->withTimestamps();
    }
    //
}
