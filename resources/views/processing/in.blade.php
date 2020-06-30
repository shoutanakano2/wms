@extends('layouts.app')
@section('content')
    <div class='text-center'>
        <h1>入庫処理</h1>
    </div>
    <p>倉庫名称</p>
     {!! $warehouse->warehouse_code !!}
    <table  border='1'>
        <thead>
            <tr>
                <th>入庫日付</th>
                <th>品目コード</th>
                <th>品目名称</th>
                <th>数量</th>
            </tr>
        </thead>
        {!! Form::open(['route'=>'stocks.store']) !!}
        <tbody class='form-group'>
            <td>{!! Form::date('date',null,['class'=>'form-control']) !!}</td>
            <td>{!! Form::text('item_code',null,['class'=>'form-control']) !!}</td>
            <td></td>
            <td>{!! Form::number('quantity',null,['class'=>'form-control']) !!}</td>
        </tbody>
            {!! Form::hidden('warehouse_id', $warehouse->warehouse_id) !!}
            {!! Form::submit('入庫',['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
        
    </table>
@endsection