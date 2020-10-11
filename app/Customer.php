<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable=['user_id','customer_code','customer_name','customer_phonenumber','customer_faxnumber','customer_email','customer_postalcode','customer_address','deleted_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
