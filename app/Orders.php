<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
protected $guarded = array('id');

    // 以下を追記
    public static $rules = array(
        'product_name' => 'required',
        'price' => 'required|integer',
        'order_datetime' => 'required',
        'user_id' => 'required',
        'user_mail_address' => 'required',
        'user_name' => 'required',
        'payment' => 'required',
        'tax' => 'required',
        'description' => 'required',
        
    );

    
}
