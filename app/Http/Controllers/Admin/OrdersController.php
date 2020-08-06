<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Storage;
use App\Orders;
use App\OrderDetail;
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

        public function check(Request $request)
        { 
            $form = $request->all();
     
            $products = Product::all();
            $total = 0;
            foreach ($products as $product) {
                if ($form['amount'][$product->id] > 0) {
                    $total += $product->price * $form['amount'][$product->id];
                }
            }
            
            return view('admin.orders.check',['products' => $products, 'form' => $form, 'total' => $total ]);
        }



public function create(Request $request)
  {
     
   // 以下を追記
      // Varidationを行う
      // $this->validate($request, Orders::$rules);

      $product = new Product;
      $allproduct = $product->all();
      //dd($allproduct);
      $products = [];
      foreach ($allproduct as $value) {
        $products[$value['id']] = $value;
      }
      $orders = new Orders;
      $form = $request->all();

      
      // フォームから画像が送信されてきたら、保存して、$orders->image_path に画像のパスを保存する
      if (isset($form['image'])) {
       $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
       $orders->image_path = Storage::disk('s3')->url($path);
      } else {
          //$orders->image_path = null;
      }
      //dd($form);
      $total = 0;
     foreach($form['amount'] as $product_id => $value) {
       if ($products[$product_id]) {
         if($products[$product_id]['price']) {
          $price = $products[$product_id]['price'];  
          $total += $price * (integer)$value;  
         }
       }
      
     }
     //dd($total);
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);
      $description = isset($form['description']) 
          ? $form['description'] 
          : '';
      
      // データベースに保存する
      $orders->fill([ 
        'order_datetime' => Carbon::now(),
        'user_mail_address' => $form['user_mail_address'],
        'user_name' => $form['user_name'],
        'total' => $total,
        'description' => $description,
        ]);
      $orders->save();
      $order_id = (integer)$orders->id;
      //dd($order_id);
      //dd($orders);
      //dd($form);
      $order_detail_new = new OrderDetail;
      foreach($form['amount'] as $product_id => $value) {
         if ($products[$product_id]) {
             if($products[$product_id]['price']) {
                $price = $products[$product_id]['price'];  
              //$products[$value['id']] = $value;
                $order_detail = clone $order_detail_new;
              //$order_detail->order_id = (integer)$orders->original['id'];
              //$order_detail->amount = (integer)$value;
              //$order_detail->price = $price;
              //$order_detail->product_id = $product_id;
                $order_detail->fill([
                    'order_id' => $order_id,
                    'amount' => (integer)$value,
                    'price' => $price,
                    'product_id' => $product_id,
                ]);
                //dd($order_detail);
                $order_detail->save();
             }
         }
      }

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
      //dd($orders);
      if (empty($orders)) {
        abort(404);    
      }
      //商品情報の取得
       $product = new Product;
      $allproduct = $product->all();
      $products = [];
      foreach ($allproduct as $value) {
        $products[$value['id']] = $value;
      }
      //注文詳細情報の取得
      $order_detail = new OrderDetail;
      $order_details = $order_detail->where('order_id', $request->id)->get();
      //dd($order_details);
      $order_details_all = [];
      //プロダクトIDをキーとした商品情報一覧
      foreach ($order_details as $value ){
         $order_details_all[$value['product_id']] = $value;
      }
      return view('admin.orders.edit', [
          'order_form' => $orders,
          'products' => $products,
          'order_details_all' => $order_details_all,
      ]);
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
