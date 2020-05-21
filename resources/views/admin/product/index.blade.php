@extends('layouts.admin')
@section('title', '登録済みニュースの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>登録済み商品一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\ProductController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\ProductController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">商品名</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="20%">商品名</th>
                                <th width="50%">詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $product)
                                <tr>
                                    <th>{{ $product->id }}</th>
                                    <td>{{ \Str::limit($product->name, 100) }}</td>
                                    <td>{{ \Str::limit($product->description, 250) }}</td>
                              
                              
                             <td>
                                        <div>
                                            <a href="{{ action('Admin\ProductController@edit', ['id' => $product->id]) }}">編集</a>
                                        </div>
 
 
                                        
                                      <div>
                                            <a href="{{ action('Admin\ProductController@delete', ['id' => $product->id]) }}">削除</a>
                                        </div>  
                                        
                                    </td> 
                              
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection