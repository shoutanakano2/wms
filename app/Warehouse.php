<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
class Warehouse extends Model
{
    use SoftDeletes;
    protected $fillable=['user_id','warehouse_code','warehouse_name','deleted_at'];
    
    //ユーザー情報の取得
    public function user(){
        Log::debug('ユーザー情報の取得');
        return $this->belongsTo(User::class);
    }
    //当倉庫で入庫処理したことのある品目の一覧
    public function having(){
        Log::debug('当倉庫で入庫処理したことのある品目の一覧');
        return $this->belongsToMany(Item::class,'stocks','warehouse_id','item_id')->using(Stock::class)->withTimestamps()->withPivot("id");;
    }
    
    //倉庫と品目の組み合わせ作成し、入庫処理
    public function matching($itemid,$stocks_id,$date,$quantity){
        Log::debug('倉庫と品目の組み合わせ作成し、入庫処理');
        $exist=$this->matched($itemid);
        if($exist==true){
            $item=$this->having()->where('item_id','=',$itemid)->first();
            $item->pivot->histories()->create([
               'stocks_id'=>$stocks_id,
	           'inout'=>1,
	           'date'=>$date,
	           'quantity'=>$quantity]);
            return true;
        }else{
            $stocks = $this->having()->attach($itemid);
            $item=$this->having()->where('item_id','=',$itemid)->first();
            $item->pivot->histories()->create([
               'stocks_id'=>$stocks_id,
	           'inout'=>1,
	           'date'=>$date,
	           'quantity'=>$quantity]);
            return true;
        }
    }
    //$itemidと倉庫の組み合わせがあるかどうか判別
    public function matched($itemid){
        Log::debug('$itemidと倉庫の組み合わせの存在判断');
        return $this->having()->where('item_id',$itemid)->exists();
    }
    //$itemidが倉庫と紐づいていたら、itemの情報を取得する。
    public function matchedStock($itemid){
        Log::debug('倉庫と紐づくitem情報の取得');
        return $this->having()->where('item_id',$itemid)->get();
    }
    
    //public function options($id){
        //$warehouse=Warehouse::find($id);
        //return view('processing.option',$date);
    //}
    //stocksテーブル情報の取得
    public function stocks(){
        Log::debug('stocksテーブル情報の取得');
        return $this->hasMany(Stock::class);
    }
}
