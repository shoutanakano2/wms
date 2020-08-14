@extends('layouts.app')
@section('content')
    <div class='text-center'>
        <h1>出庫処理</h1>
    </div>
    <p>倉庫名称</p>
     {!! $warehouse->warehouse_code !!}
 {!! Form::open(['route'=>['stocks.out',$warehouse->id]]) !!}
    <table  border='1'>
        <thead>
            <tr>
                <th>出庫日付</th>
                <th>品目コード</th>
                <th>数量</th>
            </tr>
        </thead>
        
        <tbody class='form-group'>
            <tr>
                <td>{!! Form::date('date',null,['class'=>'form-control']) !!}</td>
                <td>{!! Form::text('item_code',null,['class'=>'form-control']) !!}</td>
                <td>{!! Form::number('quantity',null,['class'=>'form-control']) !!}</td>
            </tr>
        </tbody>
    </table>
     {!! Form::submit('出庫',['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection