@extends('layouts.app2')
@section('content')
    <div class='form-wrapper'>
        <h1>品目マスタ登録</h1>
    
        <div class='form'>
            {!! Form::open(['route'=>'items.store']) !!}
                <div class='form-group'>
                    {!! Form::text('item_code',null,['class'=>'form-control','placeholder'=>'品目コード']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('item_name',null,['class'=>'form-control','placeholder'=>'品目名称']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('sell_price',null,['class'=>'form-control','placeholder'=>'売値']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('purchase_price',null,['class'=>'form-control','placeholder'=>'仕入値']) !!}
                </div>
                <div class = "button-panel">
                    {!! Form::submit('登録',['class'=>'btn']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    {{--<div class='text-center my-4'>
        <h1>品目マスタ登録</h1>
    </div>
    <div class='row mt-4'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>'items.store']) !!}
                <div class='form-group'>
                    {!! Form::label('item_code','品目コード') !!}
                    {!! Form::text('item_code',null,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('item_name','品目名称') !!}
                    {!! Form::text('item_name',null,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('sell_price','売値') !!}
                    {!! Form::text('sell_price',null,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('purchase_price','仕入値') !!}
                    {!! Form::text('purchase_price',null,['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('登録',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>--}}
    
@endsection
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpushs