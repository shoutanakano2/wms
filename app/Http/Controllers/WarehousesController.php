<?php

namespace App\Http\Controllers;
use App\Library\BaseClass;
use Illuminate\Http\Request;
use Log;
class WarehousesController extends Controller
{
    //倉庫マスタの一覧表示
    public function index(){
        Log::debug('倉庫マスタ一覧');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
        }
        return view('warehouse.list',$data);
    }
    
    //倉庫マスタの削除
    public function destroy($id){
        Log::debug('倉庫マスタの削除');
        $warehouse=\App\Warehouse::find($id);
        $histories=\DB::table('histories')
            ->join('stocks','histories.stocks_id','=','stocks.id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
            ->where('warehouse_id', $warehouse->id)
            ->first();
        if(\Auth::id()==$warehouse->user_id && $histories==Null){
            $warehouse->delete();
            return back()->with('flash_message','削除しました。');
        }
        else{
            return back()->with('flash_message','入出庫履歴を持つため削除できません。');
        }
    }
    
    //倉庫マスタの投稿
    public function store(Request $request){
        Log::debug('倉庫マスタの投稿');
        $this->validate($request,[
            'warehouse_code'=>'required|max:191|unique:warehouses,warehouse_code',
            'warehouse_name'=>'required|max:191|unique:warehouses,warehouse_name']);
        $request->user()->warehouses()->create([
            'warehouse_code'=>$request->warehouse_code,
            'warehouse_name'=>$request->warehouse_name,
            ]);
        return back()->with('flash_message','登録完了しました。');
    }
    
    //倉庫マスタの登録
    public function create(){
        Log::debug('倉庫マスタの登録');
        $warehouse = new \App\Warehouse;
        return view('warehouse.create',['warehouse=>$warehouse,']);
    }
    
    //倉庫マスタの編集
    public function edit($id){
        Log::debug('倉庫マスタの編集');
        $warehouse=\App\Warehouse::find($id);
        return view('warehouse.edit',['warehouse'=>$warehouse,]);
    }
    
    //倉庫マスタの更新投稿
    public function update(Request $request,$id){
        Log::debug('倉庫マスタの更新投稿');
        $this->validate($request,[
            'warehouse_code'=>'required|max:191|unique:warehouses,warehouse_code,'.$request->warehouse_code.',warehouse_code',
            'warehouse_name'=>'required|max:191|unique:warehouses,warehouse_name,'.$request->warehouse_name.',warehouse_name',]);
        $warehouse=\App\Warehouse::find($id);    
        $warehouse->warehouse_code=$request->warehouse_code;
        $warehouse->warehouse_name=$request->warehouse_name;
        $warehouse->save();
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
        }
        $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
        $data=['warehouses'=>$warehouses];
        return redirect()->route('warehouses.index',$data)->with('flash_message','変更しました。');
    }
    
    //入庫処理する倉庫の選択
    public function inselect(){
        Log::debug('入庫処理倉庫の選択');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
        }
        return view('processing.inselect',$data);
    }
    
    //入庫処理画面へ遷移
    public function in(Request $request,$id){
        Log::debug('入庫処理画面へ遷移');
        $warehouse=\App\Warehouse::find($id);
        $user=\Auth::user();
        $items = \App\Item::select('item_code', 'item_name')
                ->where('user_id',$user->id)
                ->OrderBy('item_code')
                ->pluck('item_code', 'item_name');
        $data = [];
        $data += $this->selectlist($data,$user);
        
        //$customers=\App\Customer::select('customer_code','customer_name')
                //->where('user_id',$user->id)
                //->OrderBy('customer_code')
                //->pluck('customer_code','customer_name');
        //$customers =[];
        //$customers += $this->customerslist($customers,$user);

        $data += [
            'warehouse'=>$warehouse,
            'items'=>$items,
            //'customers'=>$customers
            ];
        return view('processing.in',$data);
    }
    
    //出庫処理する倉庫の選択
     public function outselect(){
        Log::debug('出庫処理倉庫の選択');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
        }
        return view('processing.outselect',$data);
    }
    
    //出庫処理画面へ遷移
    public function out(Request $request,$id){
        Log::debug('出庫処理画面へ遷移');
        $warehouse=\App\Warehouse::find($id);
        $user=\Auth::user();
        $items = \App\Item::select('item_code', 'item_name')
                ->where('user_id',$user->id)
                ->OrderBy('item_code')
                ->pluck('item_code', 'item_name');
        /*$customers=\App\Customer::select('customer_code','customer_name')
                ->where('user_id',$user->id)
                ->OrderBy('customer_code')
                ->pluck('customer_code','customer_name');
        $data=['warehouse'=>$warehouse,
                'items'=>$items,
                'customers'=>$customers,];*/
        $data = [];
        $data += $this->selectlist($data,$user);
        $data += [
            'warehouse'=>$warehouse,
            'items'=>$items,
            //'customers'=>$customers
            ];
        
        return view('processing.out',$data);
    }
    
    //
    //public function deleteselect(){
        //$data=[];
        //if(\Auth::check()){
            //$user=\Auth::user();
            //$warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            //$data=['warehouses'=>$warehouses];
            //return view('processing.delete_select',$data);
        //}
    //}
    
    //
    //public function delete(Request $request,$id){
        //$warehouse=\App\Warehouse::find($id);
        //return view('processing.delete',['warehouse'=>$warehouse,]);
    //}
}
