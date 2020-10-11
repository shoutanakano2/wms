@extends('layouts.app2')
@section('content')
    <div class='text-center'>
        <h1>入出庫履歴照会</h1>
    </div>
    <div class='row'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>'histories.show']) !!}
                <div class='form-group'>
                    {!! Form::label('warehouse_code','倉庫コード') !!}
                    {!! Form::text('warehouse_code',old('warehouse_code'),['class'=>'form-control']) !!}
                    
                </div>
                <div class='form-group'>
                    {!! Form::label('item_name','品目コード') !!}
                    {!! Form::text('item_name',old('item_name'),['class'=>'form-control']) !!}
                    
                </div>
                {!! Form::submit('検索',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection