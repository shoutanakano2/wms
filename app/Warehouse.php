<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    protected $fillable=['user_id','warehouse_code','warehouse_name','deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function having(){
        //return $this->belongsToMany(Item::class,'stocks','warehouse_id','item_id')->using(Stock::class)->withTimestamps();
        return $this->belongsToMany(Item::class,'stocks','warehouse_id','item_id')->using(Stock::class)->withTimestamps()->withPivot("id");;
    }
    
    public function matching($itemid,$stocks_id,$date,$quantity){
        $exist=$this->matched($itemid);
        if($exist==true){
            $item=$this->having()->where('item_id','=',$itemid)->first();
            $item->pivot->histories()->create([
               'stocks_id'=>$stocks_id,
	           'inout'=>1,
	           'date'=>$date,
	           'quantity'=>$quantity]);
            //$stocks_id=$warehouse->matching($itemid);
            //$stocks=\App\Stock::find($stocks_id);
            //$stock->histories()->create([
            //'stocks_id'=>$request->stocks_id,
           // 'inout'=>in,
           // 'date'=>$request->date,
           // 'quantity'=>$request->quantity,]);
            return true;
        }
        else{
             $stocks = $this->having()->attach($itemid);
            $item=$this->having()->where('item_id','=',$itemid)->first();
            $item->pivot->histories()->create([
               'stocks_id'=>$stocks_id,
	           'inout'=>1,
	           'date'=>$date,
	           'quantity'=>$quantity]);
            //$stocks_id=$warehouse->matching($itemid);
            //$stocks=\App\Stock::find($stocks_id);
            //$stock=$this->matchedStock($itemid);
            return true;
        }
    }
    
    public function matched($itemid){
        return $this->having()->where('item_id',$itemid)->exists();
    }
    public function matchedStock($itemid){
        return $this->having()->where('item_id',$itemid)->get();
    }    
    public function options($id){
        $warehouse=Warehouse::find($id);
        return view('processing.option',$date);
    }
    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
