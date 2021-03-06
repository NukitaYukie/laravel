@extends('layouts.admin')
@section('title', '注文の編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>注文の編集</h2>
                <form action="{{ action('Admin\OrdersController@update') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="title">注文者</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="user_name" value="{{ $order_form->user_name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">メールアドレス</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="user_mail_address" value="{{ $order_form->user_mail_address }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">注文日時</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="order_datetime" value="{{ $order_form->order_datetime }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">商品名</div>
                        <div class="col-md-3">数量</div>
                        <div class="col-md-3">単価</div>    
                    </div> 
                    @foreach($products as $product)
                    <div class="form-group row">
                        <label class="col-md-3"> {{ $product->product_name}} </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="amount[{{ $product->id }}]" 
                            @if (isset($order_details_all[$product->id]))
                                value="{{ $order_details_all[$product->id ]['amount'] }}"
                            @else
                                value="0"
                            @endif
                            > 
                             
                        </div>
                        <div class="col-md-3"> {{ $product->price}} </div>
                    </div>
                    @endforeach
                    <div class="form-group row">
                        <label class="col-md-2">合計金額</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="{{ $order_form->total }}" disabled>
                            <input type="hidden" class="form-control" name="total" value="{{ $order_form->total }}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">備考欄</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="description" row="5">{{ $order_form->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="image">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                            <div class="form-text text-info">
                                設定中: {{ $order_form->image_path }}
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remove" value="true">画像を削除
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="id" value="{{ $order_form->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
                
           </div>
        </div>
    </div>
@endsection