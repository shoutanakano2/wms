@extends('layouts.app')
@section('content')
    <div class='text-center'>
        <h1>品目マスタ登録</h1>
    </div>
    <div class='row'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>'items.store']) !!}
                <div class='form-group'>
                    {!! Form::label('item_code','品目コード') !!}
                    {!! Form::text('item_code',old('item_code'),['class'=>'form-control']) !!}
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