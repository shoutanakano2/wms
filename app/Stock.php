<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Log;
class Stock extends Pivot
{
    protected $table = 'stocks';
    //
    protected $fillable=['warehouse_id','item_id'];
    //stocksが持つhistoriesの取得
    public function histories(){
        Log::debug('stocksが持つhistoriesの取得');
        return $this->hasMany(Historie::class,'id','stocks_id');
    }
}
