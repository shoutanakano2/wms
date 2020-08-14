@extends('layouts.app')
@section('content')
    <div class='text-center'>
        @if(Auth::check())
            <h1>倉庫管理システム</h1>
             <h2>１．マスタ関連</h2>
            <div>
                ①
                {!! link_to_route('warehouses.create','倉庫マスタ作成',[]) !!}
                
                {!! link_to_route('warehouses.index','一覧', []) !!}
                ②
                {!! link_to_route('items.create','品目マスタ作成',[]) !!}
                {!! link_to_route('items.index','一覧',[]) !!}
                
            </div>
            <h2>２．入出庫処理</h2>
            <div>
                ①
                {!! link_to_route('warehouses.inselect','入庫処理',[]) !!}
                ②
                {!! link_to_route('warehouses.outselect','出庫処理',[]) !!}
            </div>
            <h2>３．在庫管理</h2>
                ①
                {!! link_to_route('stocks.index','在庫照会',[]) !!}
                ②
                {!! link_to_route('stocks.select','入出庫履歴照会',[]) !!}
        @else
            <h1>倉庫管理システム</h1>
            {!! link_to_route('signup.get','会員登録',[],['class'=>'btn btn-lg btn-primary']) !!}
            {!! link_to_route('login','ログイン',[],['class'=>'btn btn-lg btn-primary']) !!}
        @endif
    </div>
@endsection