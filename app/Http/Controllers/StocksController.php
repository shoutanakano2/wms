<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\CSVimport;
use SplFileObject;
use Log;
use Validator;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
//require '/wms/vendor/autoload.php';

class StocksController extends Controller
{
    public function store(Request $request,$id){
        $this->validate($request,[
            'date'=>'required',
            'customer_code'=>'required',
            'item_code'=>'required',
            'quantity'=>'required|numeric|between:1,2147483647']);
        $warehouse=\App\Warehouse::find($id);
        $customer=\App\Customer::where('customer_name',$request->customer_code)->first();
        $customerid=$customer->id;
        $item=\App\Item::where('item_name',$request->item_code)->first();
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
        Log::debug('$stock');
        $history = new \App\Historie();
        $history->stocks_id=$stock_id;
        $history->inout=1;
        $history->date=$request->date;
        $history->quantity=$request->quantity;
        $history->customer_id=$customerid;
        $history->save();
        Log::debug('入庫');
        return back();
    }
    public function out(Request $request,$id){
        $this->validate($request,[
            'date'=>'required',
            'customer_code'=>'required',
            'item_code'=>'required',
            'quantity'=>'required|integer|digits_between:1,2147483647']);
        $warehouse=\App\Warehouse::find($id);
        $item=\App\Item::where('item_name',$request->item_code)->first();
        $itemid=$item->id;
        $customer=\App\Customer::where('customer_name',$request->customer_code)->first();
        $customerid=$customer->id;
        if($warehouse->matchedStock($itemid)->first()==Null){
            return back();
        }
        else{
            $stock = $warehouse->matchedStock($itemid)->first()->pivot;
            $stock_id=$stock->id;
            $inoutSums = \DB::table('histories')
                ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,stocks.item_id,stocks.warehouse_id,warehouses.warehouse_name,items.item_name'))
                ->join('stocks', 'stocks.id', '=', 'histories.stocks_id')
                ->join('items', 'items.id', '=', 'stocks.item_id')
                ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                ->groupBy('warehouses.warehouse_name','items.item_name','stocks.item_id','stocks.warehouse_id','histories.inout')
                ->where('warehouse_id', $warehouse->id)
                ->get();
            $inoutDatas=[];
            $OldwareHouse='';
            $Olditem='';
            $sum=0;
            foreach($inoutSums as $inoutSum) {
                if($OldwareHouse=='') {
                    $OldwareHouse = $inoutSum->warehouse_name;
                    $Olditem = $inoutSum->item_name;
                }
                if($OldwareHouse != $inoutSum->warehouse_name) {
                    array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum]);
                    $sum = $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                    $OldwareHouse = $inoutSum->warehouse_name;
                    $Olditem = $inoutSum->item_name;
                } elseif($Olditem != $inoutSum->item_name){
                    array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum]);
                    $sum = $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                    $Olditem = $inoutSum->item_name;
                } else {
                    $sum = $sum + $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                }
            }
            if($sum<=$request->quantity){
                return back()->with('flash_message','在庫数量以上の出庫はできません。');
            }
            else{
                $history = new \App\Historie();
                $history->stocks_id=$stock_id;
                $history->inout=2;
                $history->date=$request->date;
                $history->quantity=$request->quantity;
                $history->customer_id=$customerid;
                $history->save();
                return back();
            }
            Log::debug('出庫');
        }
    }
    public function warehouse_select(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
            return view('stocks.stocks_select',$data);
        }
    }
    public function show(Request $request,$id){
        $warehouse=\App\Warehouse::find($id);
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
                        ->where('warehouse_id', $warehouse->id)
                        ->paginate(15);
        
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
            'id'=>$id,
            ];
        Log::debug('在庫照会');
        return view('stocks.show',$data);
    }
    public function stocksCSV(Request $request,$id){
        $warehouse=\App\Warehouse::find($id);
        $inoutSums = \DB::table('histories')
                        ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,stocks.item_id,stocks.warehouse_id,warehouses.warehouse_name,items.item_name'))
                        ->join('stocks', 'stocks.id', '=', 'histories.stocks_id')
                        ->join('items', 'items.id', '=', 'stocks.item_id')
                        ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                        ->groupBy('warehouses.warehouse_name','items.item_name','stocks.item_id','stocks.warehouse_id','histories.inout')
                        ->where('warehouse_id', $warehouse->id)
                        ->get();
        $inoutDatas=[];
        $OldwareHouse='';
        $Olditem='';
        $sum=0;
        foreach($inoutSums as $inoutSum) {
            if($OldwareHouse=='') {
                $OldwareHouse = $inoutSum->warehouse_name;
                $Olditem = $inoutSum->item_name;
            }
            if($OldwareHouse != $inoutSum->warehouse_name) {
                array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum]);
                $sum = $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                $OldwareHouse = $inoutSum->warehouse_name;
                $Olditem = $inoutSum->item_name;
            
            } elseif($Olditem != $inoutSum->item_name){
                array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum]);
                $sum = $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                $Olditem = $inoutSum->item_name;
            } else {
                $sum = $sum + $this->inoutVal($inoutSum->inout,$inoutSum->sum);
            }
        }
        array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum ]);
        
        echo gettype($inoutDatas) . "\n";
        var_dump( is_array($inoutDatas) );
        $head=['倉庫名称','品目名称','数量'];
        $csvlist = $this->stocksCsvColmns(); 
        $f=fopen('test1.csv','w');
        if($f){
            mb_convert_variables('SJIS', 'UTF-8', $head);
            fputcsv($f, $head);
            
            $inoutData=[];
            foreach($inoutDatas as $inoutData){
                $data=[];
                foreach($csvlist as $key=>$value){
                    $data[] = str_replace(array("\r\n", "\r", "\n"), '', $inoutData->$key);
                }
                mb_convert_variables('SJIS', 'UTF-8', $data);
                fputcsv($f, $data);
            }
        }
        fclose($f);
        header("Content-Type: application/octet-stream");
        header('Content-Length: '.filesize('test1.csv'));
        header('Content-Disposition: attachment; filename=test1.csv');
        readfile('test1.csv');
        Log::debug('在庫照会CSV出力');
    }
    
    public function stocksPdf(Request $request,$id){
        $warehouse=\App\Warehouse::find($id);
        $inoutSums = \DB::table('histories')
                        ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,stocks.item_id,stocks.warehouse_id,warehouses.warehouse_name,items.item_name'))
                        ->join('stocks', 'stocks.id', '=', 'histories.stocks_id')
                        ->join('items', 'items.id', '=', 'stocks.item_id')
                        ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                        ->groupBy('warehouses.warehouse_name','items.item_name','stocks.item_id','stocks.warehouse_id','histories.inout')
                        ->where('warehouse_id', $warehouse->id)
                        ->get();
        $inoutDatas=[];
        $OldwareHouse='';
        $Olditem='';
        $sum=0;
        foreach($inoutSums as $inoutSum) {
            if($OldwareHouse=='') {
                $OldwareHouse = $inoutSum->warehouse_name;
                $Olditem = $inoutSum->item_name;
            }
            if($OldwareHouse != $inoutSum->warehouse_name) {
                array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum]);
                $sum = $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                $OldwareHouse = $inoutSum->warehouse_name;
                $Olditem = $inoutSum->item_name;
            
            } elseif($Olditem != $inoutSum->item_name){
                array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum]);
                $sum = $this->inoutVal($inoutSum->inout,$inoutSum->sum);
                $Olditem = $inoutSum->item_name;
            } else {
                $sum = $sum + $this->inoutVal($inoutSum->inout,$inoutSum->sum);
            }
        }
        array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum ]);
        $data=[
            'id'=>$id,
            'inoutDatas' => $inoutDatas,
            ];
        return \PDF::loadView('stocks.show',$data)->setOption('encoding', 'utf-8')->inline();
        Log::debug('在庫照会PDF出力');
    }
    
    public function stocksCsvColmns()
    {
        $csvlist = array(
            'wareHouse' => '倉庫名称',
            'item' => '品目名称',
            'sum' => '数量'
        );
        return $csvlist;
    }
    
    public function inoutVal($inout,$val) {
        if($inout == "1") {
            return $val;
        }
        return $val * -1;
    }
    
    public function historiesSelect(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
            return view('histories.histories_select',$data);
        }
    }
    public function history(Request $request,$id){
        $warehouse=\App\Warehouse::find($id);
        $histories=\DB::table('histories')
                    ->join('stocks','histories.stocks_id','=','stocks.id')
                    ->join('items', 'items.id', '=', 'stocks.item_id')
                    ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                    ->where('warehouse_id', $warehouse->id)
                    ->orderBy('histories.date','ASC')
                    ->paginate(15);
        //$warehouse=$inoutSum->warehouse_name;
        //$item=$inoutSum->item_name;
        $data=[
            'id'=>$id,
            'histories'=>$histories];
            Log::debug('入出庫履歴照会');
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
    
    public function historiesCSV(Request $request,$id){
        $warehouse=\App\Warehouse::find($id);
        $histories=\DB::table('histories')
                    ->join('stocks','histories.stocks_id','=','stocks.id')
                    ->join('items', 'items.id', '=', 'stocks.item_id')
                    ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                    ->select(\DB::raw("(CASE histories.inout WHEN 1 THEN '入庫' WHEN 2 THEN '出庫' END) AS inouthyouzi"),'histories.date','warehouses.warehouse_name','items.item_name','histories.quantity')
                    ->where('warehouse_id', $warehouse->id)
                    ->orderBy('histories.date','ASC')
                    ->get();
        $histories=$histories->toArray();
        $head=['入出庫','入出庫日付','倉庫名称','品目名称','数量'];
        $csvlist = $this->csvcolmns(); 
        
        $f=fopen('test.csv','w');
        if($f){
            mb_convert_variables('SJIS', 'UTF-8', $head);
            fputcsv($f, $head);
            $history=[];
            foreach($histories as $history){
    
                $data=[];
                foreach($csvlist as $key=>$value){
                    $data[] = str_replace(array("\r\n", "\r", "\n"), '', $history->$key);
                }
                        //echo gettype($data) . "\n";
                        //var_dump( is_array($data) );
                mb_convert_variables('SJIS', 'UTF-8', $data);
                fputcsv($f, $data);
            }
        }
        fclose($f);
        header("Content-Type: application/octet-stream");
        header('Content-Length: '.filesize('test.csv'));
        header('Content-Disposition: attachment; filename=test.csv');
        readfile('test.csv');
        Log::debug('入出庫履歴照会CSV出力');
    }
    public function csvcolmns()
    {
        $csvlist = array(
            'inouthyouzi' => '入出庫',
            'date' => '入出庫日付',
            'warehouse_name' => '倉庫名称',
            'item_name' => '品目名称',
            'quantity' => '数量'
        );
        return $csvlist;
    }
    
    public function historiesPDF(Request $request,$id){
                //$histories = \Faker\Factory::create('ja_JP');
            $warehouse=\App\Warehouse::find($id);
            $histories=\DB::table('histories')
                ->join('stocks','histories.stocks_id','=','stocks.id')
                ->join('items', 'items.id', '=', 'stocks.item_id')
                ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                ->where('warehouse_id', $warehouse->id)
                ->orderBy('histories.date','ASC')
                ->get();
            $data=[
                'id'=>$id,
                'histories'=>$histories];
                Log::debug('入出庫履歴照会PDF出力');
        return \PDF::loadView('histories.list_for_pdf',$data)->setOption('encoding', 'utf-8')->inline();
    }
    public function create(){
        $items=\App\Item::orderBy('item_code','asc')->plunk('','item_code');
    }
    public function delete($id){
        $history=\App\Historie::find($id);
        if(\Auth::id()==$history->user_id){
            $history->delete();
            return back();
        }
    }
    protected $head;
    protected $csvfilePath;

    protected $csvimport=null;
    //public function __construct(CSVimport $csvimport){
        //$this->csvimport=$csvimport;
    //}
    public function inoutfile(){
        return view('processing.import');
    }
    public function import(Request $request){
        
        setlocale(LC_ALL,'ja_JP.UTF-8');
        $uploaded_file=$request->file('csv_file');
        $file_path=$request->file('csv_file')->path($uploaded_file);
        $file=new SplFileObject($file_path);
        $file->setFlags(SplFileObject::READ_CSV);
        $row_count=1;
    
        //Goodby CSVのconfig設定
        $config = new LexerConfig();
        $interpreter = new Interpreter();
        $lexer = new Lexer($config);
        //CharsetをUTF-8に変換
        $config->setToCharset("UTF-8");
        $config->setFromCharset("sjis-win");
        $rows = array();
        $interpreter->addObserver(function(array $row) use (&$rows) {
            $rows[] = $row;
        });
        // CSVデータをパース
        $lexer->parse($file, $interpreter);
        $data = array();
        // CSVのデータを配列化
        foreach ($rows as $key => $value) {
            $arr = array();
            foreach ($value as $k => $v) {
                switch ($k) {
        	    case 0:
        	    $arr['倉庫名称'] = $v;
        	    break;
        	    case 1:
        	    $arr['入出庫種別'] = $v;
        	    break;
        	   case 2:
        	   $arr['日付']=$v;
        	   break;
        	   case 3:
        	   $arr['得意先名称']=$v;
        	   break;
        	   case 4:
        	   $arr['品目名称']=$v;
        	   break;
        	   case 5:
        	   $arr['数量']=$v;
        	   break;
        	    default:
        	    break;
            }
        }
 dd($arr);
            //　バリデーション処理
            $validator = Validator::make($arr,[
               'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255'
            ]);
 
            if ($validator->fails()) {
            $validator->errors()->add('line', $key);
            return redirect('/sample')->withErrors($validator)->withInput();
            }
 
            $data[] = $arr;
        }
 
        foreach($file as $row){
            if($row===[null])continue;
            if($row_count>1)
            {
              
  
        $warehouse_name=$row[0];
        $warehouse=\App\Warehouse::where('warehouse_name',$row[0])->first();
        
        if($row[1]='入庫')
        $inout='1';
        elseif($row[2]='出庫')
        $inout='2';
        $date=$row[2];
        $customer_name=$row[3];
        $customer=\App\Customer::where('customer_name',$customer_name)->first();
        $item_name=$row[4];
        $item=\App\Item::where('item_name',$item_name)->first();
        $quantity=$row[5];
        $stock ='';
        if ($warehouse->matched($item->id)) {
        } else {
            $stock = $warehouse->having()->attach($item->id);
        }
        $stock = $warehouse->matchedStock($item->id)->first()->pivot;
        $stock_id=$stock->id;
        
        
        $history = new \App\Historie();
        $history->stocks_id=$stock_id;
        $history->inout=$inout;
        $history->date=$date;
        $history->quantity=$quantity;
        $history->customer_id=$customer->id;
        $history->save();
        return back();
            }
            $row_count++;
        }
        Log::debug('一括入出庫');
        return view('processing.import');
    }
    
}
