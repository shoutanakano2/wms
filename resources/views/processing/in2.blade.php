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