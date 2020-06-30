@extends('layouts.app')
@section('content')
    <div class='text-center'>
        <h1>在庫照会</h1>
    </div>
    <div class='row'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>'stocks.show']) !!}
                <div class='form-group'>
                    {!! Form::label('item_code','品目コード') !!}
                    {!! Form::text('item_code',old('item_code'),['class'=>'form-control']) !!}
                    {!! Form::hidden('warehouse_code', $warehouse->warehouse_code) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('item_name','品目名称') !!}
                    {!! Form::text('item_name',old('item_name'),['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('登録',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection