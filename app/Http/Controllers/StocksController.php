<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class StocksController extends Controller
{
    
    public function store(Request $request,$id){
        $this->validate($request,[
            
            'item_code'=>'exists:items,item_code',
            'quantity'=>'required|numeric|between:1,2147483647']);
        $warehouse=\App\Warehouse::find($id);
        $item=\App\Item::where('item_code',$request->item_code)->first();
        $itemid=$item->id;
       
        //$stocks=\App\Stock::where('item_id',$itemid)->where('warehouse_id',$id)->first();
        $stock ='';
        if ($warehouse->matched($itemid)) {
            //$stock = $warehouse->matchedStock($itemid)->first()->pivot;
        } else {
            $stock = $warehouse->having()->attach($itemid);
        }
        $stock = $warehouse->matchedStock($itemid)->first()->pivot;
        
        //$warehouse->matching($itemid,$stock->id,$request->date,$request->quantity);
        //$stocks = $warehouse->matchedStock($item->id);
       
        $stock_id=$stock->id;
        
        //$warehouse->matching($itemid,$stocks_id,$request->date,$request->quantity);
        
        $history = new \App\Historie();
        $history->stocks_id=$stock_id;
        $history->inout=1;
        $history->date=$request->date;
        $history->quantity=$request->quantity;
        $history->save();
        return back();
    }
    public function out(Request $request,$id){
        $this->validate($request,[
            'item_code'=>'exists:items,item_code',
            'quantity'=>'required|integer|digits_between:1,2147483647']);
            
        $warehouse=\App\Warehouse::find($id);
        $item=\App\Item::where('item_code',$request->item_code)->first();
        $itemid=$item->id;
        $stock = $warehouse->matchedStock($itemid)->first()->pivot;
        $stock_id=$stock->id;
        
        $history = new \App\Historie();
        $history->stocks_id=$stock_id;
        $history->inout=2;
        $history->date=$request->date;
        $history->quantity=$request->quantity;
        $history->save();
        return back();
    }
    public function index(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
            return view('stocks.stocks_select',$data);
        }
    }
    public function show(Request $request,$id){
        //$warehouse=\App\Warehouse::find($id);
        //$stocks=$warehouse->stocks;
        //$stocks=\DB::table('stocks')
                    //->join('warehouses','stocks.warehouse_id','=','warehouses.id')
                    //->join('items','stocks.item_id','=','items.id')
                    //->get();
        $inoutSums = \DB::table('histories')
                        ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,stocks.item_id,stocks.warehouse_id,warehouses.warehouse_name,items.item_name'))
                        ->join('stocks', 'stocks.id', '=', 'histories.stocks_id')
                        ->join('items', 'items.id', '=', 'stocks.item_id')
                        ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                        ->groupBy('warehouses.warehouse_name','items.item_name','stocks.item_id','stocks.warehouse_id','histories.inout')
                        ->get();
                        //->groupBy('stocks.item_id','stocks.warehouse_id','items.item_name','warehouses.warehouse_name','histories.inout')
    
        //入出庫計算
        $inoutDatas=[];
        //前回値
        
        $OldwareHouse='';
        $Olditem='';
        $sum=0;
        
        foreach($inoutSums as $inoutSum) {
            //１件目はイコールとする
            if($OldwareHouse=='') {
                $OldwareHouse = $inoutSum->warehouse_name;
                $Olditem = $inoutSum->item_name;
                //$sum = inoutVal($inoutSum->inout,$inoutSum->quantity);
            }
            
            //前回と倉庫が変わったならば　前回の倉庫名＋品種名＋SUM　を　連想配列$inoutDatasへ格納
            if($OldwareHouse != $inoutSum->warehouse_name) {
                array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum]);
                $sum = $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                $OldwareHouse = $inoutSum->warehouse_name;
                $Olditem = $inoutSum->item_name;
            
            } elseif($Olditem != $inoutSum->item_name){
                 //前回と倉庫が同一で且つ品種が変わったならば　前回の倉庫名＋品種名＋SUM　を　連想配列$inoutDatasへ格納
                array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum]);
                $sum = $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                $Olditem = $inoutSum->item_name;
            } else {
                //前回と倉庫が同一で且つ品種が同一　＝＝＞　合計計算を行う　inout=1入庫＋、２は出庫でマイナス　$sum 計算のみ
                $sum = $sum + $this->inoutVal($inoutSum->inout,$inoutSum->sum);
            }
        }
        //前回の倉庫名＋品種名＋SUM　を　連想配列$inoutDatasへ格納
        array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum ]);
        $data=[
            'inoutDatas' => $inoutDatas,
            ];
            
        return view('stocks.show',$data);
        //$item=\App\Item::where('item_code',$request->item_code)->first();
        //$itemid=$item->id;
        //$warehouse=\App\Warehouse::where('warehouse_code',$request->warehouse_code)->first();
        //$stock=$warehouse->matchedStock($itemid)->first()->pivot;
        //dd($stock);
    }
    
    public function inoutVal($inout,$val) {
        if($inout == "1") {
            return $val;
        }
        return $val * -1;
    }
    
    public function select(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
            return view('histories.histories_select',$data);
        }
    }
    public function history(Request $requesr,$id){
        $warehouse=\App\Warehouse::find($id);
        $histories=\DB::table('histories')
                    ->join('stocks','histories.stocks_id','=','stocks.id')
                    ->join('items', 'items.id', '=', 'stocks.item_id')
                    ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                    ->get();
        //$warehouse=$inoutSum->warehouse_name;
        //$item=$inoutSum->item_name;
        $data=[
            'histories'=>$histories];
        return view('histories.list',$data);
    }
    protected $histories = [];
    public function all(){
        return $this->histories;
    }
    public function toArray(){
        return $this->map(function($histories){
            return $histories instanceof Arrayable ? $value->toArray() : $histories;
        })->all();
    }
    
    public function postCSV(){
        $histories=\DB::table('histories')
                    ->join('stocks','histories.stocks_id','=','stocks.id')
                    ->join('items', 'items.id', '=', 'stocks.item_id')
                    ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                    ->get();
        $histories=$histories->toArray();
        $head=['入出庫','入出庫日付','倉庫名称','品目名称','数量'];
        $csvlist = $this->csvcolmns(); 
        
        //$f=fopen('test.csv','w');
        //if($f){
            //mb_convert_variables('SJIS', 'UTF-8', $head);
            //fputcsv($f, $head);
            $history=[];
            foreach($histories as $history){
                $data=[];
                foreach($csvlist as $key=>$value){
                    $data[] = str_replace(array("\r\n", "\r", "\n"), '', $history->$key);
                    //INOUTが１だったら入庫、２だったら、出庫と変えて格納すればよいのでは。
                }
                dd($key);
                        //echo gettype($data) . "\n";
                        //var_dump( is_array($data) );
                mb_convert_variables('SJIS', 'UTF-8', $data);
                fputcsv($f, $data);
            }
        }
        //fclose($f);
        //header("Content-Type: application/octet-stream");
        //header('Content-Length: '.filesize('test.csv'));
        //header('Content-Disposition: attachment; filename=test.csv');
       // readfile('test.csv');
    //}
    public function csvcolmns()
    {
        $csvlist = array(
            'inout' => '入出庫',
            'date' => '入出庫日付',
            'warehouse_name' => '倉庫名称',
            'item_name' => '品目名称',
            'quantity' => '数量'
        );
        return $csvlist;
    }
}
