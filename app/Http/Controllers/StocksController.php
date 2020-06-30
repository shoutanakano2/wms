<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StocksController extends Controller
{
    //
    public function store(Request $request,$item_id){
        warehouse()->matching($item_id);
        return back();
    }
    
    public function show(){
        if(\Auth::check()){
            return view('stocks.select');
    }
    }
}
