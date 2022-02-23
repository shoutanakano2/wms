<?php
// app/Library/BaseClass.php
namespace app\Library;

class BaseClass
{
    //StocksController@stocksPdf,stocksCSV
    public static function inoutSums($id) {
        $warehouse=\App\Warehouse::find($id);
        $commonInoutSums = \DB::table('histories')
                        ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,stocks.item_id,stocks.warehouse_id,warehouses.warehouse_name,items.item_name'))
                        ->join('stocks', 'stocks.id', '=', 'histories.stocks_id')
                        ->join('items', 'items.id', '=', 'stocks.item_id')
                        ->join('warehouses', 'warehouses.id', '=', 'stocks.warehouse_id')
                        ->groupBy('warehouses.warehouse_name','items.item_name','stocks.item_id','stocks.warehouse_id','histories.inout')
                        ->where('warehouse_id', $warehouse->id)
                        ->get();
        return $commonInoutSums;
    }

    //CustomerController@show,invoicePDF
    public static function details($request,$id){
        $year=$request->year;
        $month=$request->month;
        $customer=\App\Customer::find($id);
        $commonDetails=\DB::table('histories')
            ->select(\DB::raw('sum(histories.quantity)as sum,histories.inout,items.item_name,customers.id,stocks.id,items.sell_price'))
            ->join('stocks','histories.stocks_id','=','stocks.id')
            ->join('items', 'items.id', '=', 'stocks.item_id')
            ->join('customers','histories.customer_id','=','customers.id')
            ->groupBy('histories.inout','items.item_name','customers.id','stocks.id','items.sell_price')
            ->where('customer_id', $customer->id)
            ->where('inout',2)
            ->whereYear('date',$year)
            ->whereMonth('date',$month)
            ->get();
        return $commonDetails;
    }
    
    //StocksController@store,out
    public static function itemId($request,$i){
     
        $item=\App\Item::where('item_name',$request->item_code[$i])->first();
        $itemid=$item->id;
        dd($item);
        return $itemid;
    }
    
    //StocksController@store,out
    public static function customerId($request,$id,$i){
        $customer=\App\Customer::where('customer_name',$request->customer_code[$i])->first();
        $customerid=optional($customer)->id;
        return $customerid;
    }
    
    //StocksController@store,out
    public static function stockId($warehouse,$itemid){
        //dd($warehouse->matchedStock($itemid)->first()->pivot);
        //$stock = $warehouse->matchedStock($itemid)->first()->pivot;
        //$stock_id=$stock->id;
        //$stock = $warehouse->matchedStock($itemid)->first()->pivot;
        $item = $warehouse->matchedStock($itemid)->first();
 //dd($stock);       
        //dd($stock);
        //$stock_id=$stock->id;
        $stock_id=$item['stock_id'];
        
        return $stock_id;    
        //$warehouse->matching($itemid,$stock->id,$request->date,$request->quantity);
        //$stocks = $warehouse->matchedStock($item->id);
    }
    
    //CustomersController@show,invoicePDF
    public static function data($id,$details,$customer,$paynumber,$date,$paydate,$tax,$total_price,$year,$month,$subtotal){
        $data=[
            'id'=>$id,
            'details'=>$details,
            'customer'=>$customer,
            'paynumber'=>$paynumber,
            'date'=>$date,
            'paydate'=>$paydate,
            'tax'=>$tax,
            'total_price'=>$total_price,
            'year'=>$year,
            'month'=>$month,
            'subtotal'=>$subtotal];
        return $data;
    }
    
    
}