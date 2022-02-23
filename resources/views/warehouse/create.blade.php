@extends('layouts.app2')
@section('content')
    <div class='form-wrapper'>
        <h1>倉庫マスタ登録</h1>
        <div class='form'>
            {!! Form::open(['route'=>'warehouses.store']) !!}
                <div class='form-group'>
                    {!! Form::text('warehouse_code',old('warehouse_code'),['class'=>'form-control','placeholder'=>'倉庫コード']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('warehouse_name',old('warehouse_name'),['class'=>'form-control','placeholder'=>'倉庫名称']) !!}
                </div>
                <div class = "button-panel">
                    {!! Form::submit('登録',['class'=>'btn']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    {{--<div class='text-center my-4'>
        <h1>倉庫マスタ登録</h1>
    </div>
    <div class='row mt-4'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>'warehouses.store']) !!}
                <div class='form-group'>
                    {!! Form::label('warehouse_code','倉庫コード') !!}
                    {!! Form::text('warehouse_code',old('warehouse_code'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('warehouse_name','倉庫名称') !!}
                    {!! Form::text('warehouse_name',old('warehouse_name'),['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('登録',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div> --}}
@endsection
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush
@section('content2')
    <div class='text-center m-4'>
        @if(Auth::check())
            <h1>メインメニュー</h1>
             <h2 class="m-3">１．マスタ関連</h2>
                <div class='h6 m-2'>
                    ①
                    {!! link_to_route('warehouses.create','倉庫マスタ作成',[]) !!}
                    /
                    {!! link_to_route('warehouses.index','一覧', []) !!}
                </div>
                <div class='h6 m-2'>
                    ②
                    {!! link_to_route('items.create','品目マスタ作成',[]) !!}
                    /
                    {!! link_to_route('items.index','一覧',[]) !!}
                </div>
            <h2 class='m-3'>２．入出庫処理</h2>
                <div class='h6 m-2'>
                    ①
                    {!! link_to_route('warehouses.inselect','入庫処理',[]) !!}
                </div>
                <div class='h6 m-2'>
                    ②
                    {!! link_to_route('warehouses.outselect','出庫処理',[]) !!}
                </div>
                <div>
                    ③
                    {!! link_to_route('warehouses.deleteselect','取消処理',[]) !!}
                </div>
            <h2 class='m-3'>３．在庫管理</h2>
                <div class='h6 m-2'>
                    ①
                    {!! link_to_route('warehouses.stocksSelect','在庫照会   ',[]) !!}
                </div>
                <div class='h6 m-2'>
                    ②
                    {!! link_to_route('warehouses.historiesSelect','入出庫履歴照会',[]) !!}
                </div>
        @else
            <h1 class="m-4">倉庫管理システム</h1>
                {!! link_to_route('signup.get','会員登録',[],['class'=>'btn btn-lg btn-primary']) !!}
                {!! link_to_route('login','ログイン',[],['class'=>'btn btn-lg btn-primary']) !!}
        @endif
    </div>
@endsection