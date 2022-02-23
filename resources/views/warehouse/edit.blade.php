@extends('layouts.app2')
@section('content')
    <div class='form-wrapper'>
        <h1>倉庫マスタ変更</h1>
        <div class='form'>
            {!! Form::open(['route'=>['warehouses.update',$warehouse->id],'method'=>'put']) !!}
                <div class='form-group'>
                    {{--{!! Form::label('warehouse_code','倉庫コード') !!}--}}
                    {!! Form::text('warehouse_code',old('warehouse_code',$warehouse->warehouse_code),['class'=>'form-control','placeholder'=>'倉庫コード']) !!}
                </div>
                <div class='form-group'>
                    {{--{!! Form::label('warehouse_name','倉庫名称') !!}--}}
                    {!! Form::text('warehouse_name',old('warehouse_name',$warehouse->warehouse_name),['class'=>'form-control','placeholder'=>'倉庫名称']) !!}
                </div>
                <div class = "button-panel">
                    {!! Form::submit('変更',['class'=>'btn btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    {{--<div class='text-center'>
        <h1>倉庫マスタ変更</h1>
    </div>
    <div class='row'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>['warehouses.update',$warehouse->id],'method'=>'put']) !!}
                <div class='form-group'>
                    {!! Form::label('warehouse_code','倉庫コード') !!}
                    {!! Form::text('warehouse_code',old('warehouse_code',$warehouse->warehouse_code),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('warehouse_name','倉庫名称') !!}
                    {!! Form::text('warehouse_name',old('warehouse_name',$warehouse->warehouse_name),['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('変更',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    --}}
@endsection
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush