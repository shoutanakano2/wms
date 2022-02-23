<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Library\BaseClass;
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
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
class StocksController extends Controller
{
    //入庫処理
    public function store(Request $request,$id){
        Log::debug('入庫');
        /*
        //バリデーション
        $this->validate($request,[
            //'date'=>'required|date|after_or_equal:' . Carbon::now()->startOfMonth()->toDateString(),
            'customer_code'=>'required',
            'item_code'=>'required',
            //'quantity'=>'required|numeric|between:1,2147483647']);
        // 通常のバリデーション
        //$validator = Validator::make($request->all(), [
	        //現在のばーりでーしょんのまま
            //'date'=>'required|after:Carbon::now()->startOfMonth()->toDateString()',
            //'customer_code'=>'required',
            //'item_code'=>'required',
            //'quantity'=>'required|numeric|between:1,2147483647']);
        //$validator->validate();
        // 追加で入力チェックを行う
        //if ( $validator->fails() ) {
            //$validator->errors()->add('feed_url', 'このURLにはRSSフィードが含まれていません。');
            //return back()->withInput()->withErrors($validator);
        //}
        //投入された値から、DBに保存する値を求る。
       
        $validator =$request->validate([
            //'quantity.*' => 'required_with:item_code.*|numeric|between:0,2147483647',
             'quantity.*' => 'required|Integer',
             'customer_code.*'=>'required',
            'item_code.*'=>'required',
        ]);
    */
        $validator = Validator::make($request->all(),[]);
        $validator->validate();
        $warehouse=\App\Warehouse::find($id);
        
        $j = 0;
        foreach((array)$request->quantity as $value){
            if ( $request->date[$j] == null && $request->customer_code[$j] != null && $request->item_code[$j] != null && $request->quantity[$j] != 0) {
                $validator->errors()->add('', ($j+1) .'行目の入荷日が入力されていません。');
                return back()->withInput()->withErrors($validator);
                //exit(($j+1) .'行目の入荷日が入力されていません。');
            }elseif($request->date[$j] != null && $request->customer_code[$j] == null && $request->item_code[$j] != null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の仕入先が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] != null && $request->item_code[$j] == null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の品目コードが入力されていま。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] != null && $request->item_code[$j] != null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] == null && $request->item_code[$j] != null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の入荷日と仕入先コードが入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] != null && $request->item_code[$j] == null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の入荷日と品目コードが入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] != null && $request->item_code[$j] != null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の入荷日と数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] == null && $request->item_code[$j] == null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の仕入先コードと品目コードが入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] == null && $request->item_code[$j] != null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の仕入先コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] != null && $request->item_code[$j] == null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の品目コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] == null && $request->item_code[$j] == null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の入荷日と仕入先コードと品目コードが入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] == null && $request->item_code[$j] != null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の入荷日と仕入先コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] != null && $request->item_code[$j] == null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の入荷日と品目コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] == null && $request->item_code[$j] == null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の仕入先コードと品目コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }
            else{
                $j++;
            }
        }
        
        $i = 0;
        foreach((array)$request->quantity as $val){
           //バリデーション
           /*
            $this->validate($request,[
                'date'=>'required|date|after_or_equal:' . Carbon::now()->startOfMonth()->toDateString(),
                'customer_code'=>'required',
                'item_code'=>'required',
                'quantity'=>'required|numeric|between:1,2147483647']);
        
            */
            
            if($val=="0"){
                return back()->with('flash_message','入庫完了しました。');
            }else{
            //$itemid = BaseClass::itemId($request,$i);
            $item=\App\Item::where('item_name',$request->item_code[$i])->first();
            
            $itemid = $item['id']; 
            //$itemid=optional($item)->id; 

            $customerid = BaseClass::customerId($request,$id,$i);
      
            //倉庫と品目の組み合わせがなければ、作成し、その変数を取得する。
            $stock ='';
            if ($warehouse->matched($itemid)) {
            } else {
                $stock = $warehouse->having()->attach($itemid);
            }
            $stock_id = BaseClass::stockId($warehouse,$itemid);
            
            //DBに値を保存する。
            $history = new \App\Historie();
            $history->stocks_id = $stock_id;
            $history->inout=1;
            $history->date=$request->date[$i];
            $history->quantity=$request->quantity[$i];
            $history->customer_id=$customerid;
            $history->change_status='可';
            $history->save();
            $i++;
            }
        }
        
        //====================================================
        return back()->with('flash_message','入庫完了しました。');
    }
    
    //出庫処理
    public function out(Request $request,$id){
        Log::debug('出庫');
        /*複数明細用に変更する。
        //バリデーション
        $this->validate($request,[
            'date'=>'required|after_or_equal:' . Carbon::now()->startOfMonth()->toDateString(),
            'customer_code'=>'required',
            'item_code'=>'required',
            'quantity'=>'required|integer|digits_between:1,2147483647']);
        //投入された値から、DBに保存する値を求め、その値をDBに保存する。
        */
        $validator = Validator::make($request->all(),[]);
        $validator->validate();
        
        $j = 0;
        foreach((array)$request->quantity as $value){
            if ( $request->date[$j] == null && $request->customer_code[$j] != null && $request->item_code[$j] != null && $request->quantity[$j] != 0) {
                $validator->errors()->add('', ($j+1) .'行目の出荷日が入力されていません。');
                return back()->withInput()->withErrors($validator);
                //exit(($j+1) .'行目の出荷日が入力されていません。');
            }elseif($request->date[$j] != null && $request->customer_code[$j] == null && $request->item_code[$j] != null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の得意先が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] != null && $request->item_code[$j] == null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の品目コードが入力されていま。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] != null && $request->item_code[$j] != null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] == null && $request->item_code[$j] != null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の出荷日と得意先コードが入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] != null && $request->item_code[$j] == null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の出荷日と品目コードが入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] != null && $request->item_code[$j] != null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の出荷日と数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] == null && $request->item_code[$j] == null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の得意先コードと品目コードが入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] == null && $request->item_code[$j] != null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の得意先コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] != null && $request->item_code[$j] == null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の品目コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] == null && $request->item_code[$j] == null && $request->quantity[$j] != 0){
                $validator->errors()->add('', ($j+1) .'行目の出荷日と得意先コードと品目コードが入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] == null && $request->item_code[$j] != null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の出荷日と得意先コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] == null && $request->customer_code[$j] != null && $request->item_code[$j] == null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の出荷日と品目コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }elseif($request->date[$j] != null && $request->customer_code[$j] == null && $request->item_code[$j] == null && $request->quantity[$j] == 0){
                $validator->errors()->add('', ($j+1) .'行目の得意先コードと品目コードと数量が入力されていません。');
                return back()->withInput()->withErrors($validator);
            }
            else{
                $j++;
            }
        }
        $warehouse=\App\Warehouse::find($id);
        $itemid = BaseClass::itemId($request,$id);
        $customerid = BaseClass::customerId($request,$id);
        
        //入庫したことのない品目か、出庫処理できる在庫があるか確認する。、
        if($warehouse->matchedStock($itemid)->first()==Null){
            return back()->with('flash_message','在庫が有りません。');
        }else{
            $stock_id = BaseClass::stockId($warehouse,$itemid);
            $inoutSums = \DB::table('histories')
                ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,stocks.item_id,stocks.warehouse_id,warehouses.warehouse_name,items.item_name'))
                ->join('stocks', 'stocks.id', '=', 'histories.stocks_id')
                ->join('items', 'items.id', '=', 'stocks.item_id')
                ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                ->groupBy('warehouses.warehouse_name','items.item_name','stocks.item_id','stocks.warehouse_id','histories.inout')
                ->where('warehouse_id', $warehouse->id)
                ->where('item_id',$itemid)
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
            
            //出庫可能な在庫が有れば、DBに値を保存する。
            if($sum <= $request->quantity[$i]){
                return back()->with('flash_message','在庫数量以上の出庫はできません。');
            }else{
                $history = new \App\Historie();
                $history->stocks_id=$stock_id;
                $history->inout=2;
                $history->date=$request->date[$i];
                $history->quantity=$request->quantity[$i];
                $history->customer_id=$customerid;
                $history->change_status='可';
                $history->save();
                $i++;
                return back()->with('flash_message','出庫完了しました。');
            }
        }
    }
    
    //入出庫処理する倉庫を選択する。
    public function warehouse_select(){
        Log::debug('倉庫選択');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
            return view('stocks.stocks_select',$data);
        }
    }
    
    //在庫一覧を表示する。
    public function show(Request $request,$id){
        Log::debug('在庫照会');
        //倉庫、品種、入出庫の値が同じ組み合わせをリストアップ
        $warehouse=\App\Warehouse::find($id);
        $inoutSums = \DB::table('histories')
                        ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,stocks.item_id,stocks.warehouse_id,warehouses.warehouse_name,items.item_name'))
                        ->join('stocks', 'stocks.id', '=', 'histories.stocks_id')
                        ->join('items', 'items.id', '=', 'stocks.item_id')
                        ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                        ->groupBy('warehouses.warehouse_name','items.item_name','stocks.item_id','stocks.warehouse_id','histories.inout')
                        ->where('warehouse_id', $warehouse->id)
                        //->dump()
                        ->paginate(15);
        
        //入出庫計算
        $inoutDatas=[];
        //前回値
        $OldwareHouse='';
        $Olditem='';
        $sum = 0;
    
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
        
        /*$inoutDatas = new \LengthAwarePaginator(
            $inoutDatas->forPage($request->page, 20),
            count($inoutDatas),
            20,
            $request->page,
            array('path' => $request->url())
        );
        array_push($inoutDatas,['wareHouse'=>$OldwareHouse,'item' => $Olditem,'sum'=>$sum ]);
        $all_num=count($inoutDatas);
        $disp_limit = 20;
        $inoutDatas = new LengthAwarePaginator($inoutDatas , $all_num, $disp_limit, $page, array('path'=>'/player'));
        */
        //dd($inoutDatas);
        $data=[
            'inoutDatas' => $inoutDatas,
            'id'=>$id,];
        return view('stocks.show',$data);
    }
    
    //在庫をCSVデータとして取得する。
    public function stocksCSV(Request $request,$id){
        Log::debug('在庫照会CSV出力');
        $inoutSums = BaseClass::inoutSums($id);
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
        
        $head=['倉庫名称','品目名称','数量'];
        $csvlist = $this->stocksCsvColmns(); 
        $fp = fopen('test1.csv', 'w');
        if($fp){
            mb_convert_variables('SJIS', 'UTF-8', $head);
            fputcsv($fp, $head);
            $inoutDatacsvs=[];
            
            foreach($inoutDatas as $inoutData){
                $data=[];
                foreach($inoutData as $key => $value){
                    $data[] = str_replace(array("\r\n", "\r", "\n"), '', $value);
                }
                $inoutDatacsvs[] = $data;
                mb_convert_variables('SJIS', 'UTF-8', $data);
                fputcsv($fp, $data);
            }
            fclose($fp);
        }
        header("Content-Type: application/octet-stream");
        header('Content-Length: '.filesize('test1.csv'));
        header('Content-Disposition: attachment; filename=test1.csv');
        readfile('test1.csv');
    }
    
    //在庫をPDFで取得する。
    public function stocksPdf(Request $request,$id){
        Log::debug('在庫照会PDF出力');
        $inoutSums = BaseClass::inoutSums($id);
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
            'inoutDatas' => $inoutDatas,];
        return \PDF::loadView('stocks.pdf',$data)->setOption('encoding', 'utf-8')->inline();
    }
    
    public function stocksCsvColmns()
    {
        $csvlist = array(
            'wareHouse' => '倉庫名称',
            'item' => '品目名称',
            'sum' => '数量');
        return $csvlist;
    }
    
    //入庫の場合は数量に×１、出庫の場合は数量に×(-1)
    public function inoutVal($inout,$val) {
        if($inout == "1") {
            return $val;
        }else{
        return $val * -1;
        }
    }
    
    //入出庫履歴を確認する倉庫を選択
    public function historiesSelect(){
        Log::debug('入出庫履歴を確認する倉庫を選択');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $warehouses=$user->warehouses()->orderBy('created_at','desc')->paginate(10);
            $data=['warehouses'=>$warehouses];
            return view('histories.histories_select',$data);
        }
    }
    
    //入出庫履歴を確認する。
    public function history(Request $request,$id){
        Log::debug('入出庫履歴照会');
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
        return view('histories.list',$data);
    }
    
    //protected $histories = [];
    //public function all(){
        //return $this->histories;
    //}
    public function toArray(){
        return $this->map(function($histories){
            //return $histories instanceof Arrayable ? $value->toArray() : $histories;
        })->all();
    }
    
    
    //入出庫履歴をCSVデータで取得
    public function historiesCSV(Request $request,$id){
        Log::debug('入出庫履歴CSV取得');
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
    public function csvcolmns(){
        $csvlist = array(
            'inouthyouzi' => '入出庫',
            'date' => '入出庫日付',
            'warehouse_name' => '倉庫名称',
            'item_name' => '品目名称',
            'quantity' => '数量'
        );
        return $csvlist;
    }
    
    //入出庫履歴をPDFで出力する。
    public function historiesPDF(Request $request,$id){
        Log::debug('入出庫履歴照会PDF出力');
            //$histories = \Faker\Factory::create('ja_JP');
        $warehouse=\App\Warehouse::find($id);
        $histories=\DB::table('histories')
            ->join('stocks','histories.stocks_id','=','stocks.id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
            ->where('warehouse_id', $warehouse->id)
            ->orderBy('histories.date','ASC')
            ->get();
        $data=['id'=>$id,
            'histories'=>$histories];
        return \PDF::loadView('histories.list_for_pdf',$data)->setOption('encoding', 'utf-8')->inline();
    }
    
    //item_codeを取得する。
    public function create(){
        Log::debug('item_codeの取得');
        $items=\App\Item::orderBy('item_code','asc')->plunk('','item_code');
    }
    
    //入出庫の取り消し
    public function delete($id){
        Log::debug('入出庫取消');
        //該当の商品の在庫数を調べる。
        $history=\App\Historie::find($id);
        $inoutSums = \DB::table('histories')
            ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,stocks.item_id,stocks.warehouse_id,warehouses.warehouse_name,items.item_name'))
            ->join('stocks', 'stocks.id', '=', 'histories.stocks_id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
            ->groupBy('warehouses.warehouse_name','items.item_name','stocks.item_id','stocks.warehouse_id','histories.inout')
            ->where('stocks_id', $history->stocks_id)
            ->get();
            
        $sum=0;
        foreach($inoutSums as $inoutSum) {
                $sum = $sum + $this->inoutVal($inoutSum->inout,$inoutSum->sum);}
        //取り消し対象が入庫か、出庫かを調査する。
        $userid=\DB::table('histories')
            ->join('stocks','histories.stocks_id','=','stocks.id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->select('items.user_id','histories.inout')
            ->where('histories.id', $history->id)
            ->first();
        
        //入庫処理かつ、取り消し後にその商品の在庫がマイナスになる→OUT、そうでなければ→safeとする。
        $judge='';
        if($history->inout==1 && $sum - $history->quantity < 0){
            $judge='out';
            
        }else{
            $judge='safe';
        }

        //残高を調べ、その入庫を消しても問題ないか   状況次第でコメントを表示
        if($judge=='out'){
            return back()->with('flash_message','在庫数が不足するため取り消しできません。');
        }elseif(\Auth::id()==$userid->user_id && $history->change_status=='可' ){
            $history->delete();
            return back()->with('flash_message','取り消し完了しました。');
        }else{
            return back()->with('flash_message','取り消しできません。');
        }
    }

    //一括入出庫用CSVファイルの取り込み画面を表示
    public function inoutfile(){
        return view('processing.import');
    }
    
    //一括入出庫用CSVファイルの取り込み
    public function import(Request $request){
        Log::debug('一括入出庫');
        //***** suda add start 2010.10.12 *****
        if(!$request->hasFile('csv_file') ) {
            return back()->with('flash_message','CSVファイルを選択して下さい。');
        }
        elseif(!$request->file('csv_file')->isValid()) {
            return back()->with('flash_message','CSVファイルをが正しくありません。');
        }    
        else {
            $request->file('csv_file')->move(public_path()."/storage/csv/",$_FILES['csv_file']['name']);
            $file_path = public_path()."/storage/csv/".$_FILES['csv_file']['name'];
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
        $lexer->parse($file_path, $interpreter);
        $data = array();
        // CSVのデータを配列化
        foreach ($rows as  $value) {
            $arr=[];
            foreach ($value as $k => $v) {
                Log::debug("*** " . $v);
                if($v=='倉庫名称'){
                    continue;
                }if($v=='入出庫種別'){
                    continue;
                }if($v=='日付'){
                    continue;
                }if($v=='得意先名称'){
                    continue;
                }if($v=='品目名称'){
                    continue;
                }if($v=='数量'){
                    continue;
                }
                $csv_key[]=$k;
                $csv_value[]=$v;
                $column_name=[];
                if($k==0){
                    $arr += [$k =>$v];
                }if($k==1){
                    $arr += [$k =>$v];
                    //$arr = array_merge($arr,array($k =>$v));
                    //array_push($column_name,'入出庫種別');
                    //array_push($csv_value,$v);                   
                }if($k==2){
                    $arr += [$k =>$v];
                }if($k==3){
                    $arr += [$k =>$v];
                }if($k==4){
                    $arr += [$k =>$v];
                }if($k==5){
                    $arr += [$k =>$v];
                }
                //$value_count++;
                $value++;
            }
        }
        dd($arr);
        //　バリデーション処理
        $validator = Validator::make($arr,[
            0 => 'required|exists:warehouses,warehouse_name',
            1 => 'required|in:入庫,出庫',
            2 => 'required|date|after_or_equal:' . Carbon::now()->startOfMonth()->toDateString(),
            3 => 'required|exists:customers,customer_name',
            4 => 'required|exists:items,item_name',
            5 => 'required|numeric|between:1,2147483647'
        ]);
        //バリデーションでエラーが発生下場合は、エラーメッセージとともに取り込みが面へ
        if ($validator->fails()) {
            $validator->errors()->add('line', $v);
            return view('processing.import')->withErrors($validator);
        }

        //historiesテーブルに値を格納
        foreach($file as $row){
            if($row===[null])continue;
            if($row_count>1){
                $warehouse_name=$row[0];
                $warehouse=\App\Warehouse::where('warehouse_name',$row[0])->first();
                
                if($row[1] == '入庫'){
                    $inout='1';
                }elseif($row[1] == '出庫'){
                    $inout='2';
                }
                $date=$row[2];
                $customer_name=$row[3];
                $customer=\App\Customer::where('customer_name',$customer_name)->first();
                $item_name=$row[4];
                $item=\App\Item::where('item_name',$item_name)->first();
                $quantity=$row[5];
                $stock ='';
                
                if ($warehouse->matched($item->id)) {
                }else {
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
                $history->change_status='可';
                $history->save();
                return back();
            }
            $row_count++;
        }
        return view('processing.import')->with('flash_message','一括処理完了しました。');
    }
}
