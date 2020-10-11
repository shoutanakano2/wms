<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//require_once './vendor/autoload.php';
use Carbon\Carbon;
use Log;
class CustomersController extends Controller
{
    public function list(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $customers=$user->customers()->orderBy('created_at','desc')->paginate(10);
            $data=['customers'=>$customers];
            }
        return view('customers.list',$data);
    }
    
    public function index(){
        $data=[];
        if(\Auth::check()){
            $user=\Auth::user();
            $customers=$user->customers()->orderBy('created_at','desc')->paginate(10);
            $data=['customers'=>$customers];
        }
        return view('invoice.select',$data);
    }
    public function destroy($id){
        $customer=\App\Customer::find($id);
        $histories=\DB::table('histories')
            ->where('customer_id',$customer->id)
            ->first();
        if(\Auth::id()==$customer->user_id && $histories==Null){
            $customer->delete();
            return back();
        }
        return back()->with('flash_message','入出庫履歴を持つため削除できません。');
    }
    
    public function store(Request $request)
    {
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
        return back();
    }
    public function create(){
        $customer = new \App\Customer;
        return view('customers.create',
        ['customer=>$customer']);
    }
    
    public function edit($id){
        $customer=\App\Customer::find($id);
        return view('customers.edit',[
            'customer'=>$customer,]);
    }
    
    public function update(Request $request,$id){
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
        }
        return view('customers.list',$data);
    }

    public function show(Request $request,$id){
        $customer=\App\Customer::find($id);
        $details=\DB::table('histories')
                    ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,items.item_name,customers.id,stocks.id,items.sell_price'))
                    ->join('stocks','histories.stocks_id','=','stocks.id')
                    ->join('items', 'items.id', '=', 'stocks.item_id')
                    ->join('customers','histories.customer_id','=','customers.id')
                    ->groupBy('histories.inout','items.item_name','customers.id','stocks.id','items.sell_price')
                    ->where('customer_id', $customer->id)
                    ->where('inout',2)
                    ->get();
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
        $data=[
            'id'=>$id,
            'details'=>$details,
            'customer'=>$customer,
            'paynumber'=>$paynumber,
            'date'=>$date,
            'paydate'=>$paydate,
            'tax'=>$tax,
            'total_price'=>$total_price];
        return view('invoice.list',$data);
        Log::debug('請求書発行');
    }
}