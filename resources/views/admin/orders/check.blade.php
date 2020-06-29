{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', '新規作成の確認')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>新規作成の確認</h2>
                
                <form action="{{ action('Admin\OrdersController@create') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-3">注文者</label>
                        <div class="col-md-7">
                        {{ $form['user_name'] }}
                        <input type="hidden" name="user_name" value="{{ $form['user_name'] }}"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">メールアドレス</label>
                        <div class="col-md-7">
                        {{ $form['user_mail_address'] }} 
                         <input type="hidden" name="user_mail_address" value="{{ $form['user_mail_address'] }}"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">商品名</div>
                        <div class="col-md-2">数量</div>
                        <div class="col-md-2">単価</div>    
                        <div class="col-md-2">小計</div>
                    </div>
                    @foreach($products as $product)
                    <div class="form-group row">
                        <label class="col-md-3"> {{ $product->product_name}} </label>
                        <div class="col-md-2">
                             {{ $form['amount'][$product->id ] }}
                        </div>
                        <div class="col-md-2"> {{ $product->price}} </div>
                        <div class="col-md-2">
                            @if ($form['amount'][$product->id] > 0)
                                {{ $form['amount'][$product->id] * $product->price }}
                        
                            @else
                            0
                            @endif
                            <input type="hidden" name="amount[{{ $product->id }}]" value="{{ $form['amount'][$product->id] }}">
                        </div>        
                    </div>
                    @endforeach
                    <div class="form-group row">
                        <div class="col-md-7">合計</div>
                        <div class="col-md-2">
                            {{ $total }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">画像</label>
                        <div class="col-md-10">
                          
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="新規登録">
                </form>
                
                
            </div>
        </div>
    </div>
@endsection