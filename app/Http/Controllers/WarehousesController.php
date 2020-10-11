<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehousesController extends Controller
{
    //  
    public function index(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
        }
        return view('warehouse.list',$data);
    }
    
    public function destroy($id){
        $warehouse=\App\Warehouse::find($id);
        $histories=\DB::table('histories')
            ->join('stocks','histories.stocks_id','=','stocks.id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
            ->where('warehouse_id', $warehouse->id)
            ->first();
        if(\Auth::id()==$warehouse->user_id && $histories==Null){
            $warehouse->delete();
            return back();
        }
        else{
            return back()->with('flash_message','入出庫履歴を持つため削除できません。');
        }
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'warehouse_code'=>'required|max:191|unique:warehouses,warehouse_code',
            'warehouse_name'=>'required|max:191|unique:warehouses,warehouse_name']);
        $request->user()->warehouses()->create([
            'warehouse_code'=>$request->warehouse_code,
            'warehouse_name'=>$request->warehouse_name,
            ]);
        return back();
    }
    public function create(){
        $warehouse = new \App\Warehouse;
        return view('warehouse.create',
        ['warehouse=>$warehouse,']);
    }
    public function edit($id){
        $warehouse=\App\Warehouse::find($id);
        return view('warehouse.edit',[
            'warehouse'=>$warehouse,]);
    }
    
    public function update(Request $request,$id){
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
        return view('warehouse.list',$data);
    }
    
    public function inselect(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
        }
        return view('processing.inselect',$data);
    }
    public function in(Request $request,$id){
        $warehouse=\App\Warehouse::find($id);
        $user=\Auth::user();
        //$warehouse->id=$request->id;
        //$warehouse->warehouse_code=$request->warehouse_code;
        //$warehouse->save();
        //$items=\DB::table('items')
                    //->join('users','users.id','=','items.user_id')
                    //->where('user_id',$user->id)
                    //->get();       
        $items = \App\Item::select('item_code', 'item_name')
                ->where('user_id',$user->id)
                ->OrderBy('item_code')
                ->pluck('item_code', 'item_name');
        $customers=\App\Customer::select('customer_code','customer_name')
                ->where('user_id',$user->id)
                ->OrderBy('customer_code')
                ->pluck('customer_code','customer_name');
            $data=[
            'warehouse'=>$warehouse,
            'items'=>$items,
            'customers'=>$customers];
        return view('processing.in',$data);
    }
    
     public function outselect(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
        }
        return view('processing.outselect',$data);
    }
    public function out(Request $request,$id){
        $warehouse=\App\Warehouse::find($id);
        $user=\Auth::user();
        //$warehouse->id=$request->id;
        //$warehouse->warehouse_code=$request->warehouse_code;
        //$warehouse->save();
        $items = \App\Item::select('item_code', 'item_name')
                ->where('user_id',$user->id)
                ->OrderBy('item_code')
                ->pluck('item_code', 'item_name');
        $customers=\App\Customer::select('customer_code','customer_name')
                ->where('user_id',$user->id)
                ->OrderBy('customer_code')
                ->pluck('customer_code','customer_name');
        $data=['warehouse'=>$warehouse,
                'items'=>$items,
                'customers'=>$customers,];
        return view('processing.out',$data);
    }
    public function deleteselect(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
            return view('processing.delete_select',$data);
        }
    }
        public function delete(Request $request,$id){
        $warehouse=\App\Warehouse::find($id);
        return view('processing.delete',['warehouse'=>$warehouse,]);
    }
}
