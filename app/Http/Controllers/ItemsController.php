<?php

namespace App\Http\Controllers;
use App\Library\BaseClass;
use Illuminate\Http\Request;
use Log;
class ItemsController extends Controller
{
    //品目マスタ一覧表示
    public function index(){
        Log::debug('品目マスタ一覧表示');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $items=$user->items()->orderBy('created_at','desc')->paginate(10);
            $data=['items'=>$items];
        }
        return view('item.list',$data);
    }
    
    //品目マスタ削除
    public function destroy($id){
        Log::debug('品目マスタ削除');
        $item=\App\Item::find($id);
        $histories=\DB::table('histories')
            ->join('stocks','histories.stocks_id','=','stocks.id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
            ->where('item_id', $item->id)
            ->first();
        if(\Auth::id()==$item->user_id && $histories==Null){
            $item->delete();
            return back()->with('flash_message','削除しました。');
        }
        return back()->with('flash_message','入出庫履歴を持つため削除できません。');
    }
    
    //品目マスタ投稿
    public function store(Request $request)
    {
        Log::debug('品目マスタ投稿');
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
        return back()->with('flash_message','登録完了しました。');
    }
    
    //品目マスタ登録
    public function create(){
        Log::debug('品目マスタ登録');
        $item=new \App\Item;
        return view('item.create',['item=>$item',]);
    }
    
    //品目マスタ編集登録
    public function edit($id){
        Log::debug('品目マスタ編集登録');
        $item=\App\Item::find($id);
        return view('item.edit',['item'=>$item,]);
    }
    
    //品目マスタ編集投稿
    public function update(Request $request,$id){
        Log::debug('品目マスタ編集投稿');
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
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $items=$user->items()->orderBy('created_at','desc')->paginate(10);
            $data=['items'=>$items];
        }
        $items=$user->items()->orderBy('created_at','desc')->paginate(10);
        $data=['items'=>$items];
        return redirect()->route('items.index',$data)->with('flash_message','変更しました。');
    }
}
