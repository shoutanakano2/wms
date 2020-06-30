<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=['user_id','item_code','item_name'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function haved(){
        return $this->belongsToMany(Warehouse::class,'stocks','item_id','warehouse_id')->withTimestamps();
    }
    //
}
