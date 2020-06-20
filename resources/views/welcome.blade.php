@extends('layouts.app')
@section('content')
    <div class='text-center'>
        @if(Auth::check())
            <h1>倉庫管理システム</h1>
             <h2>１．マスタ関連</h2>
            <div>
                ①
                倉庫マスタ作成
                一覧
                ②
                品目マスタ作成
                一覧
                
            </div>
            <h2>２．入出庫処理</h2>
            ①入庫処理
            ②出庫処理
            <h2>３．在庫管理</h2>
            ①在庫照会
            ②入出庫履歴照会
        @else
            <h1>倉庫管理システム</h1>
            {!! link_to_route('signup.get','会員登録',[],['class'=>'btn btn-lg btn-primary']) !!}
            {!! link_to_route('login','ログイン',[],['class'=>'btn btn-lg btn-primary']) !!}
        @endif
    </div>
@endsection