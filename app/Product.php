<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
protected $guarded = array('id');

    // 以下を追記
    public static $rules = array(
        'product_name' => 'required',
        'price' => 'required',
    );

    // 以下を追記
    // Productモデルに関連付けを行う
    // public function histories()
    // {
    //   return $this->hasMany('App\History');

    // }
}
