@extends('layouts.admin')
@section('title', '注文一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>注文一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\OrdersController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\OrdersController@index') }}" method="get">
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
                                <th width="20%">注文者名</th>
                                <th width="50%">値段</th>
                                <th width="50%">注文日</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $orders)
                                <tr>
                                    <th>{{ $orders->id }}</th>
                                    <td>{{ \Str::limit($orders->orders_name, 100) }}</td>
                                    <td>{{ \Str::limit($orders->price, 250) }}</td>
                                    <td>{{ \Str::limit($orders->order_datetime, 250) }}</td>
                              
                             <td>
                                        <div>
                                            <a href="{{ action('Admin\OrdersController@edit', ['id' => $orders->id]) }}">編集</a>
                                        </div>
 
 
                                        
                                      <div>
                                            <a href="{{ action('Admin\OrdersController@delete', ['id' => $orders->id]) }}">削除</a>
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