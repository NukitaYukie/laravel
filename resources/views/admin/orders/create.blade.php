{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', '注文の新規作成')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>注文の新規作成</h2>
                
                <form action="{{ action('Admin\OrdersController@check') }}" method="post" enctype="multipart/form-data">

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
                            <input type="text" class="form-control" name="user_name" value="{{ old('user_name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">メールアドレス</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="user_mail_address" value="{{ old('user_mail_address') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">注文日時</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="order_datetime" value="{{ old('order_datetime') }}">
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
                             <input type="text" class="form-control" name="amount[{{ $product->id }}]" value="{{ old('price') }}">
                        </div>
                        <div class="col-md-3"> {{ $product->price}} </div>
                    </div>
                    @endforeach
                   
                    <div class="form-group row">
                        <label class="col-md-3">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="確認ページへ">
                </form>
                
                
            </div>
        </div>
    </div>
@endsection