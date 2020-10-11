@extends('layouts.app2')
@section('content')
    <div class='text-center my-4'>
        <h1>出庫処理</h1>
    </div>
    @if(session('flash_message'))
        <div class='flash_message alert alert-danger m-2' role='alert'>
            {{ session('flash_message') }}
        </div>
    @endif
    <p>倉庫名称:{!! $warehouse->warehouse_code !!}</p>
     {!! Form::open(['route'=>['stocks.out',$warehouse->id]]) !!}
    <table class='table table-striped' border='1'>
        <thead>
            <tr>
                <th>出庫日付</th>
                <th>得意先コード</th>
                <th>品目コード</th>
                <th>数量</th>
            </tr>
        </thead>
        <tbody class='form-group'>
            <tr>
                <td>{!! Form::date('date',null,['class'=>'form-control']) !!}</td>
                <td>{!! Form::select('customer_code',$customers,null,['class'=>'form-control']) !!}</td>
                <td>{!! Form::select('item_code',$items,null,['class'=>'form-control']) !!}</td>
                <td>{!! Form::number('quantity',null,['class'=>'form-control']) !!}</td>
            </tr>
        </tbody>
    </table>
    <div class="float-right">
        {!! Form::submit('出庫',['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection