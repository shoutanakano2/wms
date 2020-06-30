<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    //
    protected $fillable=['user_id','warehouse_code','warehouse_name'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function having(){
        return $this->belongsToMany(Item::class,'stocks','warehouse_id','item_id')->withTimestamps();
    }
    
    public function matching($itemid){
        $exist=$this->matched($itemid);
        if($exist==true){
            return false;
        }
        else{
            $this->having()->attach($itemid);
            return true;
        }
    }
    
    public function matched($itemid){
        return $this->having()->where('item_id',$itemid)->exists();
    }
    
    public function options($id){
        $warehouse=Warehouse::find($id);
        return view('processing.option',$date);
    }
}
