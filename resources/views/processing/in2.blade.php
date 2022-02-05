@extends('layouts.app2')
@section('content')
    <div class='text-center'>
        <h1 class='my-4'>入庫処理</h1>
    </div>
    <p>倉庫名称: {!! $warehouse->warehouse_code !!}</p>
    <form action='stocks.matching' method='post'>
        <input type='date' name='date'>
        <input type='text' name='item_code'>
        <input type='number' name='quantity'>
        <input type='hidden' name='warehouse_id' value='$warehouse->id'>
        <input type='submit' value='入庫'>
    </form>
    
@endsection

  <form action='stocks.matching' method='post'>
        <table class='table table-striped' border='1'>
            <thead>
                <tr>
                    <th>入庫日付</th>
                    <th>品目コード</th>
                    <th>数量</th>
                </tr>
            </thead>
            <tbody class='form-group'>
                    <tr>
                        <td><input type='date' name='date'></td>
                        <td><input type='text' name='item_code'></td>
                        <td><input type='number' name='quantity'></td>
                    </tr>
            </tbody> 
        </table>
        <input type='hidden' name='warehouse_id' value='$warehouse->id'>
        <input type='submit' value='入庫'>
    </form>
    {!! Form::text('item_code',null,['class'=>'form-control']) !!}
    
    
元に戻したければ、下記を使用(2021.1.17)
    <div class='text-center'>
        <h1 class='my-4'>入庫処理</h1>
    </div>
    <p>倉庫名称: {!! $warehouse->warehouse_code !!}</p>
    {!! Form::open(['route'=>['stocks.matching',$warehouse->id]]) !!}
    <table class='table table-striped' border='1'>
        <thead>
            <tr>
                <th>入庫日付</th>
                <th>仕入先コード</th>
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
        {!! Form::submit('入庫',['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    
    
    
    
{!! Form::select('item_code[]',$items,null,['class'=>'form-control']) !!}
{{ Form::select('itemsArray[]', $itemsArray,old('item_code'), ['class' => 'my_class','id' => 'responsible_cd']) }}
{!! Form::select('customer_code[]',$customers,null,['class'=>'form-control']) !!}
{!! Form::hidden('number[]',$i) !!}