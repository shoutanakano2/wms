<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
class Item extends Model
{
    use SoftDeletes;
    protected $fillable=['user_id','item_code','item_name','sell_price','purchase_price','deleted_at'];
    //itemの作成ユーザーの取得
    public function user(){
        Log::debug('itemの作成ユーザーの取得');
        return $this->belongsTo(User::class);
    }
    
    //当itemが入庫されたことのある倉庫の一覧
    public function haved(){
        Log::debug('itemが入庫処理されたことのある倉庫の一覧');
        return $this->belongsToMany(Warehouse::class,'stocks','item_id','warehouse_id')->withTimestamps();
    }
    
}
