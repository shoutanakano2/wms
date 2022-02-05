@extends('layouts.app2')
@section('content')
    <div class='text-center'>
        <h1 class='my-4'>入庫処理</h1>
    </div>
    <p>倉庫名称: {!! $warehouse->warehouse_code !!}</p>
    {!! Form::open(['route'=>['stocks.matching',$warehouse->id]]) !!}
    {{ csrf_field() }}
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
            @for($i = 0 ; $i < 3; $i ++)
                <tr>
                    <td>{!! Form::date('date[]',null,['class'=>'form-control']) !!}</td>
                    <td>{!! Form::select('customer_code['.$i.']', $customersArray,old('customer_code['.$i.']'), ['class' => 'my_class','id' => 'responsible_cd']) !!}</td>
                    <td>{!! Form::select('item_code[]', $itemsArray,null, ['class' => 'my_class','id' => 'responsible_cd']) !!}</td>
                    <td>{!! Form::number('quantity[]',0,['class'=>'form-control']) !!}</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <div class="float-right">
        {!! Form::submit('入庫',['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection
