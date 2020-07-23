<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = array('id');

    // 以下を追記
    public static $rules = array(
        //'product_name' => 'required',
        'order_id' => 'required|integer',
        'product_id' => 'required|integer',
        'amount' => 'required|integer',
        'price' => 'required|integer',
        
        
    );

    
}
