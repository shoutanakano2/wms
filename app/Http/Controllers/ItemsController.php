<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
class ItemsController extends Controller
{
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
        $histories=\DB::table('histories')
            ->join('stocks','histories.stocks_id','=','stocks.id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
            ->where('item_id', $item->id)
            ->first();
        if(\Auth::id()==$item->user_id && $histories==Null){
            $item->delete();
            return back();
        }
        Log::debug('品目マスタ削除');
        return back()->with('flash_message','入出庫履歴を持つため削除できません。');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'item_code'=>'required|max:191|unique:items,item_code',
            'item_name'=>'required|max:191|unique:items,item_name',
            'sell_price'=>'required|numeric|between:1,2147483647',
            'purchase_price'=>'required|numeric|between:1,2147483647']);
        $request->user()->items()->create([
            'item_code'=>$request->item_code,
            'item_name'=>$request->item_name,
            'sell_price'=>$request->sell_price,
            'purchase_price'=>$request->purchase_price,
            ]);
            Log::debug('品目マスタ登録');
        return back();
    }
    public function create(){
        $item=new \App\Item;
        return view('item.create',[
            'item=>$item',]);
    }
    
    public function edit($id){
        $item=\App\Item::find($id);
        return view('item.edit',[
            'item'=>$item,]);
            
    }
    public function update(Request $request,$id){
        $this->validate($request,[
            'item_code'=>'required|max:191|unique:items,item_code,'.$request->item_code.',item_code',
            'item_name'=>'required|max:191|unique:items,item_code,'.$request->item_name.',item_name',
            'sell_price'=>'required|numeric|between:1,2147483647',
            'purchase_price'=>'required|numeric|between:1,2147483647']);
            
        $item=\App\Item::find($id);    
        $item->item_code=$request->item_code;
        $item->item_name=$request->item_name;
        $item->sell_price=$request->sell_price;
        $item->purchase_price=$request->purchase_price;
        $item->save();
        Log::debug('$item');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $items=$user->items()->orderBy('created_at','desc')->paginate(10);
            $data=['items'=>$items];
        }
        Log::debug('品目マスタ更新');
        return view('item.list',$data);
    }
}
