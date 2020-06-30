<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemsController extends Controller
{
    //
    public function index(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $items=$user->items()->orderBy('created_at','desc')->paginate(10);
            $data=['items'=>$items];
        }
        return view('item.list',$data);
    }
    
    public function destroy($id){
        $item=\App\Item::find($id);
        if(\Auth::id()==$item->user_id){
            $item->delete();
        }
        return back();
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'item_code'=>'required|max:191',
            'item_name'=>'required|max:191']);
        $request->user()->items()->create([
            'item_code'=>$request->item_code,
            'item_name'=>$request->item_name,
            ]);
        return back();
    }
    public function create(){
        $warehouse = new \App\Warehouse;
        return view('item.create',
        ['item=>$item']);
    }
    
    public function edit($id){
        $item=\App\Item::find($id);
         
        return view('item.edit',[
            'item'=>$item,]);
            
    }
    public function update(Request $request,$id){
        
       
        $this->validate($request,[
            'item_code'=>'required|max:191',
            'item_name'=>'required|max:191']);
            
        $item=\App\Item::find($id);    
        $item->item_code=$request->item_code;
        $item->item_name=$request->item_name;
        $item->save();
        
        return back();
    }
}
