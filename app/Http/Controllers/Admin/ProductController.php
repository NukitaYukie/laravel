<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Storage;
use App\Product;

class ProductController extends Controller
{
    // 以下を追記
    public function add()
    {
        return view('admin.product.create');
    }

    public function create(Request $request)
    {
        // 以下を追記
        // Varidationを行う
        $this->validate($request, Product::$rules);

        $form = $request->all();
        //dd($form);
        $product = new Product;
        // フォームから画像が送信されてきたら、保存して、$product->image_path に画像のパスを保存する
        if (isset($form['image'])) {
            $path = Storage::disk('s3')->putFile('/', $form['image'], 'public');
            $product->image_path = Storage::disk('s3')->url($path);
        } else {
            $product->image_path = null;
        }

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $product->fill($form);
        $product->save();

        // admin/product/createにリダイレクトする
        return redirect('admin/product');
    }

    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            // 検索されたら検索結果を取得する
            $posts = Product::where('title', $cond_title)->get();
        } else {
            // それ以外はすべてのニュースを取得する
            $posts = Product::all();
        }
        return view('admin.product.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }

    public function edit(Request $request)
    {
        // product Modelからデータを取得する
        $product = Product::find($request->id);
        if (empty($product)) {
            abort(404);
        }
        return view('admin.product.edit', ['product_form' => $product]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Product::$rules);

        // product Modelからデータを取得する
        $product = Product::find($request->id);

        // 送信されてきたフォームデータを格納する
        $product_form = $request->all();

        if (isset($product_form['image'])) {
            $path = Storage::disk('s3')->putFile('/', $form['image'], 'public');
            $product->image_path = Storage::disk('s3')->url($path);
            unset($product_form['image']);
        } elseif (isset($request->remove)) {
            $product->image_path = null;
            unset($product_form['remove']);
        }
        unset($product_form['_token']);

        // 該当するデータを上書きして保存する
        $product->fill($product_form)->save();

        // 以下を追記
        // $history = new History;
        // $history->product_id = $news->id;
        // $history->edited_at = Carbon::now();
        // $history->save();

        return redirect('admin/product');
    }

    public function delete(Request $request)
    {
        // 該当するproduct Modelを取得
        $product = Product::find($request->id);
        // 削除する
        $product->delete();
        return redirect('admin/product/');
    }
}
