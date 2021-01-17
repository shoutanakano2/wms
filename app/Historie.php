<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;
class Historie extends Model
{
    //
    protected $fillable=['stocks_id','inout','date','quantity'];
    //入出庫された倉庫の取得
    public function warehouse(){
        return $this->belongsTo(Stocks::class);
    }
}
