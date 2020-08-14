<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Stock extends Pivot
{
     protected $table = 'stocks';
    //
    protected $fillable=['warehouse_id','item_id'];
    
    public function histories(){
        return $this->hasMany(Historie::class,'id','stocks_id');
    }
}
