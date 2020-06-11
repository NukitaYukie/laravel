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
                        <div class="col-md-2">商品名</div>
                        <div class="col-md-5">数量</div>
                        <div class="col-md-5">単価</div>    
                        
                    </div>
                    @foreach($products as $product)
                    <div class="form-group row">
                        <label class="col-md-2"> {{ $product->product_name}} </label>
                        <div class="col-md-5">
                             <input type="text" class="form-control" name="price[{{ $product->id }}]" value="{{ old('price') }}">
                        </div>
                        <div class="col-md-5"> {{ $product->price}} </div>
                    </div>
                    @endforeach
                   
                    <div class="form-group row">
                        <label class="col-md-2">画像</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
                
                
            </div>
        </div>
    </div>
@endsection