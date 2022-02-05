<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use App\Item;
use App\Customer;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function selectlist($data,$user)
    {
                
        // key,value ペアに直す
        //$staffs = Staff::OrderBy('staff_cd')->get()->pluck( 'staff_nm','staff_cd');
        /*
        $items = \App\Item::select('item_code', 'item_name')
                ->where('user_id',$user->id)
                ->OrderBy('item_code')
                ->pluck('item_code', 'item_name');
        */
        $items = Item::select('item_code', 'item_name')->where('user_id',$user->id)->OrderBy('item_code')->pluck('item_code', 'item_name');
        $itemsArray = $items->toArray();
        $itemsArray += array('' => "") ;
        $customerslist = Customer::select('customer_code', 'customer_name')->where('user_id',$user->id)->OrderBy('customer_code')->pluck('customer_code', 'customer_name');
        $customersArray = $customerslist->toArray();
        $customersArray += array('' => "") ;
        $data += [
            'itemsArray' => $itemsArray,
            'customersArray' => $customersArray
        ];
        return $data;
    }
    
    /*public function customerslist($customers,$user){
        $customerslist = Customer::select('customer_code', 'customer_name')->where('user_id',$user->id)->OrderBy('customer_code')->pluck('customer_code', 'customer_name');
        $customersArray = $customerslist->toArray();
        $customersArray += array('' => "") ;
        $customers += [
            'customersArray' => $customersArray,
        ];
        return $customers;
    }*/
    
    
}
