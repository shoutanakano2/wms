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
    public static function itemId($request,$id){
        $item=\App\Item::where('item_name',$request->item_code)->first();
        $itemid=$item->id;
        return $itemid;
    }
    
    //StocksController@store,out
    public static function customerId($request,$id){
        $customer=\App\Customer::where('customer_name',$request->customer_code)->first();
        $customerid=$customer->id;
        return $customerid;
    }
    
    //StocksController@store,out
    public static function stockId($warehouse,$itemid){
        $stock = $warehouse->matchedStock($itemid)->first()->pivot;
        $stock_id=$stock->id;
        return $stock_id;    
        //$warehouse->matching($itemid,$stock->id,$request->date,$request->quantity);
        //$stocks = $warehouse->matchedStock($item->id);
    }
    
    //CustomersController@129,173
    public static function data($id,$details,$customer,$paynumber,$date,$paydate,$tax,$total_price,$year,$month){
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
            'month'=>$month,];
        return $data;
    }
    
    
}