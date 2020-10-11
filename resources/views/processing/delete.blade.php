@extends('layouts.app2')
@section('content')
    <div class='text-center'>
        <h1>取消処理</h1>
    </div>
    @if(session('flash_message'))
        <div class='flash_message alert alert-danger m-2' role='alert'>
            {{ session('flash_message') }}
        </div>
    @endif
    <p>倉庫名称:{!! $warehouse->warehouse_code !!}</p>
     {!! Form::open(['route'=>['histories.delete',$warehouse->id]]) !!}
    <table class='table table-striped' border='1'>
        <thead>
            <tr>
                <th>処理番号</th>
            </tr>
        </thead>
        <tbody class='form-group'>
            <tr>
                <td>{!! Form::date('date',null,['class'=>'form-control']) !!}</td>
            </tr>
        </tbody>
    </table>
    <div class="float-right">
        {!! Form::submit('出庫',['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    
    <div class='row'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>'histories.delete']) !!}
                <div class='form-group'>
                    {!! Form::label('id','処理番号') !!}
                    {!! Form::text('id',old('id'),['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('取消',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div> 
    
    
@endsection