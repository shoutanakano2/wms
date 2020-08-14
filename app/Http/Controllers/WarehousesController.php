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
        if(\Auth::id()==$warehouse->user_id){
            $warehouse->delete();
        }
        return back();
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'warehouse_code'=>'required|max:191',
            'warehouse_name'=>'required|max:191']);
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
            'warehouse_code'=>'required|max:191',
            'warehouse_name'=>'required|max:191']);
            
        $warehouse=\App\Warehouse::find($id);    
        $warehouse->warehouse_code=$request->warehouse_code;
        $warehouse->warehouse_name=$request->warehouse_name;
        $warehouse->save();
        
        return back();
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
        //$warehouse->id=$request->id;
        //$warehouse->warehouse_code=$request->warehouse_code;
        //$warehouse->save();
        return view('processing.in',['warehouse'=>$warehouse,]);
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
        //$warehouse->id=$request->id;
        //$warehouse->warehouse_code=$request->warehouse_code;
        //$warehouse->save();
        return view('processing.out',['warehouse'=>$warehouse,]);
    }
    
}
