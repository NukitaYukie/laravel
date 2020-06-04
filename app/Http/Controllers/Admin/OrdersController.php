<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Storage;
use App\Orders;
use App\Product;
class OrdersController extends Controller
{
  // 以下を追記
  public function add()
  {
    $products = Product::all();
    \Debugbar::info($products);
      
      return view('admin.orders.create', ['products' => $products]);
  }





public function create(Request $request)
  {
     
   // 以下を追記
      // Varidationを行う
      $this->validate($request, Orders::$rules);

      $orders = new Orders;
      $form = $request->all();

      
      // フォームから画像が送信されてきたら、保存して、$orders->image_path に画像のパスを保存する
      if (isset($form['image'])) {
       $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
       $orders->image_path = Storage::disk('s3')->url($path);
      } else {
          $orders->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $orders->fill($form);
      $orders->save();
  
     

      // admin/orders/createにリダイレクトする
      return redirect('admin/orders');
  } 
  
  
public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Orders::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Orders::all();
      }
      return view('admin.orders.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }

  
  public function edit(Request $request)
  {
      // orders Modelからデータを取得する
      $orders = Orders::find($request->id);
      if (empty($orders)) {
        abort(404);    
      }
      return view('admin.orders.edit', ['orders_form' => $orders]);
  }


  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Orders::$rules);
      // orders Modelからデータを取得する
      $orders = Orders::find($request->id);
      // 送信されてきたフォームデータを格納する
      $orders_form = $request->all();
     
     
      unset($orders_form['_token']);

      // 該当するデータを上書きして保存する
      $orders->fill($orders_form)->save();

      

      return redirect('admin/orders');
        
      }
      public function delete(Request $request)
  {
      // 該当するorders Modelを取得
      $orders = Orders::find($request->id);
      // 削除する
      $orders->delete();
      return redirect('admin/orders/');
   
}
}
