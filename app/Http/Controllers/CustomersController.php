<?php

namespace App\Http\Controllers;
use App\Library\BaseClass;
use Illuminate\Http\Request;
//require_once './vendor/autoload.php';
use Carbon\Carbon;
use Log;
class CustomersController extends Controller
{
    //得意先のリストを表示
    public function list(){
        Log::debug('得意先リスト表示');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $customers=$user->customers()->orderBy('created_at','desc')->paginate(10);
            $data=['customers'=>$customers];
        }
        return view('customers.list',$data);
    }
    
    //請求書対象の得意先リスト表示
    public function index(){
        Log::debug('請求書対象の得意先リストの表示');
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $customers=$user->customers()->orderBy('created_at','desc')->paginate(10);
            $data=['customers'=>$customers];
        }
        return view('invoice.select',$data);
    }
    
    //請求月の選択
    public function month_choose($id){
        Log::debug('請求月の選択');
        $customer=\App\Customer::find($id);
        $data=['customer'=>$customer];
        return view('invoice.month_year',$data);
    }
    
    //得意先マスタの削除
    public function destroy($id){
        Log::debug('得意先マスタの削除');
        $customer=\App\Customer::find($id);
        $histories=\DB::table('histories')
            ->where('customer_id',$customer->id)
            ->first();
        if(\Auth::id()==$customer->user_id && $histories==Null){
            $customer->delete();
            return back()->with('flash_message','削除しました。');
        }
        return back()->with('flash_message','入出庫履歴を持つため削除できません。');
    }
    
    //得意先マスタの投稿
    public function store(Request $request)
    {
        Log::debug('得意先マスタの投稿');
        $this->validate($request,[
            'customer_code'=>'required|max:191|unique:customers,customer_code',
            'customer_name'=>'required|max:191|unique:customers,customer_name',
            'customer_phonenumber'=>'required|max:13|unique:customers,customer_phonenumber',
            'customer_faxnumber'=>'required|max:13|unique:customers,customer_faxnumber',
            'customer_email'=>'required|unique:customers,customer_email',
            'customer_postalcode'=>'required|max:8',
            'customer_address'=>'required|unique:customers,customer_address'
        ]);
        $request->user()->customers()->create([
            'customer_code'=>$request->customer_code,
            'customer_name'=>$request->customer_name,
            'customer_phonenumber'=>$request->customer_phonenumber,
            'customer_faxnumber'=>$request->customer_faxnumber,
            'customer_email'=>$request->customer_email,
            'customer_postalcode'=>$request->customer_postalcode,
            'customer_address'=>$request->customer_address,
        ]);
        return back()->with('flash_message','登録完了しました。');
    }
    
    //得意先マスタの登録
    public function create(){
        Log::debug('得意先マスタの登録');
        $customer = new \App\Customer;
        return view('customers.create',['customer=>$customer']);
    }
    
    //得意先マスタの編集登録
    public function edit($id){
        Log::debug('得意先マスタの編集登録');
        $customer=\App\Customer::find($id);
        return view('customers.edit',['customer'=>$customer,]);
    }
    
    //得意先マスタの更新投稿
    public function update(Request $request,$id){
        Log::debug('得意先マスタの更新投稿');
        $this->validate($request,[
            'customer_code'=>'required|max:191|unique:customers,customer_code,'.$request->customer_code.',customer_code',
            'customer_name'=>'required|max:191|unique:customers,customer_name,'.$request->customer_name.',customer_name',
            'customer_phonenumber'=>'required|max:13|unique:customers,customer_phonenumber,'.$request->customer_phonenumber.',customer_phonenumber',
            'customer_faxnumber'=>'required|max:13|unique:customers,customer_faxnumber,'.$request->customer_faxnumber.',customer_faxnumber',
            'customer_email'=>'required|unique:customers,customer_email,'.$request->customer_email.',customer_email',
            'customer_postalcode'=>'required|max:8|unique:customers,customer_postalcode,'.$request->customer_postalcode.',customer_postalcode',
            'customer_address'=>'required|unique:customers,customer_address,'.$request->customer_address.',customer_address',
            ]);
        $customer=\App\Customer::find($id);    
        $customer->customer_code=$request->customer_code;
        $customer->customer_name=$request->customer_name;
        $customer->customer_phonenumber=$request->customer_phonenumber;
        $customer->customer_faxnumber=$request->customer_faxnumber;
        $customer->customer_email=$request->customer_email;
        $customer->customer_postalcode=$request->customer_postalcode;
        $customer->customer_address=$request->customer_address;
        $customer->save();
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $customers=$user->customers()->orderBy('created_at','desc')->paginate(10);
            $data=['customers'=>$customers];
            return redirect()->route('customers.list',$data)->with('flash_message','変更しました。');
        }else{
            return view('customers.list',$data)->with('flash_message','ログインされたユーザー以外は更新できません');
        }
    }
    
    //請求書の表示
    public function show(Request $request,$id){
        Log::debug('請求書表示');
        //該当年月の取引があったかを確認
        $year=$request->year;
        $month=$request->month;
        $customer=\App\Customer::find($id);
        $exist=\DB::table('histories')
                    ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,items.item_name,customers.id,stocks.id,items.sell_price'))
                    ->join('stocks','histories.stocks_id','=','stocks.id')
                    ->join('items', 'items.id', '=', 'stocks.item_id')
                    ->join('customers','histories.customer_id','=','customers.id')
                    ->groupBy('histories.inout','items.item_name','customers.id','stocks.id','items.sell_price')
                    ->where('customer_id', $customer->id)
                    ->where('inout',2)
                    ->whereYear('date',$year)
                    ->whereMonth('date',$month)
                    ->count();
        //取引がなかった場合、
        if($exist==0 && \Auth::check()){
            $customer=\App\Customer::find($id);
            $data=['customer'=>$customer];
            return redirect()->route('customers.month_select',$customer->id)->with('message', $year.'年'.$month.'月の売上はありませんでした。');
        //取引があった場合、    
        }else {
            //取引履歴を取得
            $details = BaseClass::details($request,$id);
            $paynumber=Carbon::now()->firstOfMonth()->addDay(-1)->toDateString().$customer->id;
            $date=Carbon::now()->firstOfMonth()->toDateString();
            $paydate=Carbon::now()->lastOfMonth()->toDateString();
            $subtotal=0;
            foreach($details as $detail){
                $item=$detail->item_name;
                $sell_price=$detail->sell_price;
                $sum=$detail->sum;
                $subtotal+=intval($sell_price)*intval($sum);
            }
            $total_price=$subtotal*1.1;
            $tax=$subtotal*0.1;
            $data = BaseClass::data($id,$details,$customer,$paynumber,$date,$paydate,$tax,$total_price,$year,$month);
            return view('invoice.list',$data);
        }
    }
    
    //請求書PDF表示
    public function invoicePDF(Request $request,$id){
        Log::debug('請求書PDF表示');
        $year=$request->year;
        $month=$request->month;
        $customer=\App\Customer::find($id);
        $details = BaseClass::details($request,$id);
        $paynumber=Carbon::now()->firstOfMonth()->addDay(-1)->toDateString().$customer->id;
        $date=Carbon::now()->firstOfMonth()->toDateString();
        $paydate=Carbon::now()->lastOfMonth()->toDateString();
        $subtotal=0;
        foreach($details as $detail){
            $sell_price=$detail->sell_price;
            $sum=$detail->sum;
            $subtotal+=intval($sell_price)*intval($sum);
        }
        $total_price=$subtotal*1.1;
        $tax=$subtotal*0.1;
        $data = BaseClass::data($id,$details,$customer,$paynumber,$date,$paydate,$tax,$total_price,$year,$month);
        return \PDF::loadView('invoice.pdf',$data)->setOption('encoding', 'utf-8')->inline();
    }
}