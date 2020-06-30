@extends('layouts.app')
@section('content')
    <div class='text-center'>
        <h1>品目マスタ変更</h1>
    </div>
    <div class='row'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>['items.update',$item->id],'method'=>'put']) !!}
                <div class='form-group'>
                    {!! Form::label('item_code','品目コード') !!}
                    {!! Form::text('item_code',null,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('item_name','品目名称') !!}
                    {!! Form::text('item_name',null,['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('変更',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection