<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historie extends Model
{
    //
    protected $fillable=['stocks_id','inout','date','quantity'];
    public function warehouse(){
        return $this->belongsTo(Stocks::class);
    }
}
