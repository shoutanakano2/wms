@extends('layouts.app')
@section('content')
    <div class='text-center'>
        <h1>倉庫マスタ登録</h1>
    </div>
    <div class='row'>
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
    </div>
@endsection