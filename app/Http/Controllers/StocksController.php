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
use App\Stock;
use App\Historie;
class StocksController extends Controller
{
    public function store(Request $request,$id){
        $this->validate($request,[
            'date'=>'required|after:Carbon::now()->startOfMonth()',
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
        $history->change_status='可';
        $history->save();
        Log::debug('入庫');
        return back();
    }
    public function out(Request $request,$id){
        $this->validate($request,[
            'date'=>'required|after:Carbon::now()->startOfMonth()',
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
                $history->change_status='可';
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
                    ->select('histories.inout','histories.id','histories.date','warehouses.warehouse_name','items.item_name','histories.quantity','items.user_id')
                    ->where('warehouse_id', $warehouse->id)
                    ->orderBy('histories.date','ASC')
                    ->paginate(25);
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
        $userid=\DB::table('histories')
            ->join('stocks','histories.stocks_id','=','stocks.id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->select('items.user_id','histories.inout')
            ->where('histories.id', $history->id)
            ->first();
        if(\Auth::id()==$userid->user_id && $history->change_status=='可'){
            $history->delete();
            return back();
        }
        return back()->with('flash_message','取り消しできません。');
    }
    //protected $head;
    //protected $csvfilePath;
    //protected $csvimport=null;
    //public function __construct(CSVimport $csvimport){
        //$this->csvimport=$csvimport;
    //}
    public function inoutfile(){
        return view('processing.import');
    }
    public function import(Request $request){
        //***** suda add start 2010.10.12 *****
        if(!$request->hasFile('csv_file') ) {
            return back()->with('flash_message','CSVファイルを選択して下さい。');
        }
        elseif(!$request->file('csv_file')->isValid()) {
            return back()->with('flash_message','CSVファイルをが正しくありません。');
        }    
        //elseif($request->hasFile('csv_file') && $request->file('csv_file')->isValid()) {
        else {
            $request->file('csv_file')->move(public_path()."/storage/csv/",$_FILES['csv_file']['name']);
            $file_path = public_path()."/storage/csv/".$_FILES['csv_file']['name'];
            //dd($file_path);
         }
        //***** suda add end 2010.10.12 ******
 
        setlocale(LC_ALL,'ja_JP.UTF-8');
        //$uploaded_file=$request->file('csv_file');        
        //$file_path=$request->file('csv_file')->path($uploaded_file);

        $file=new SplFileObject($file_path);
        $file->setFlags(SplFileObject::READ_CSV);
        $row_count=1;
        
        //postで受け取ったcsvファイルデータ

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
        //$lexer->parse($file, $interpreter);
        $lexer->parse($file_path, $interpreter);
        
        $data = array();
        // CSVのデータを配列化
        foreach ($rows as  $value) {
            $arr=[];
            foreach ($value as $k => $v) {
                Log::debug("*** " . $v);
                if($v=='倉庫名称'){
                    continue;}
                if($v=='入出庫種別'){
                    continue;}
                if($v=='日付'){
                    continue;}
                if($v=='得意先名称'){
                    continue;}
                if($v=='品目名称'){
                    continue;}
                if($v=='数量'){
                    continue;}
                    
                $csv_key[]=$k;
                $csv_value[]=$v;
                $column_name=[];
                
                if($k==0){
                    $arr += [$k =>$v];}
                if($k==1){
                    $arr += [$k =>$v];}
                    //$arr = array_merge($arr,array($k =>$v));
                    //array_push($column_name,'入出庫種別');
                    //array_push($csv_value,$v);
                if($k==2){
                    $arr += [$k =>$v];}
                if($k==3){
                    $arr += [$k =>$v];}
                if($k==4){
                    $arr += [$k =>$v];}
                if($k==5){
                    $arr += [$k =>$v];}
            }
        }
            //　バリデーション処理
            $validator = Validator::make($arr,[
                0 => 'required|exists:warehouses,warehouse_name',
                1=> 'required|in:入庫,出庫',
                2=>'required|date|after:Carbon::now()->startOfMonth();',
                3=>'required|exists:customers,customer_name',
                4=>'required|exists:items,item_name',
                5=>'required|numeric|between:1,2147483647'
            ]);

            if ($validator->fails()) {
                $validator->errors()->add('line', $v);
                //return view('processing.import')->withErrors($validator)->withInput();
                return view('processing.import')->withErrors($validator);}
        
 //$fileでOK？→OKそう。
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
                    $stock = $warehouse->having()->attach($item->id);}
                $stock = $warehouse->matchedStock($item->id)->first()->pivot;
                $stock_id=$stock->id;
                $history = new \App\Historie();
                $history->stocks_id=$stock_id;
                $history->inout=$inout;
                $history->date=$date;
                $history->quantity=$quantity;
                $history->customer_id=$customer->id;
                $history->change_status='可';
                $history->save();
                return back();
            }
            $row_count++;
        }
        Log::debug('一括入出庫');
        return view('processing.import');
    }
}
