@extends('layouts.app2')
@section('content')
    <h1>出庫処理<p>(倉庫名称:{!! $warehouse->warehouse_code !!})</p></h1>
     {!! Form::open(['route'=>['stocks.out',$warehouse->id]]) !!}
    <table border='1'>
        <thead>
            <tr>
                <th scope='col' class="text-center">出庫日付</th>
                <th scope='col' class="text-center">得意先コード</th>
                <th scope='col' class="text-center">品目コード</th>
                <th scope='col' class="text-center">数量</th>
            </tr>
        </thead>
        <tbody class='form-group'>
            @for($i = 0 ; $i < 3; $i ++)
                <tr>
                    <td data-label="出庫日付">{!! Form::date('date[]',null,['class'=>'form-control text-center']) !!}</td>
                    <td data-label="得意先コード">{!! Form::select('customer_code['.$i.']',$customersArray,old('customer_code['.$i.']'),['class' => 'my_class','id' => 'responsible_cd']) !!}</td>
                    <td data-label="品目コード">{!! Form::select('item_code[]',$itemsArray,null,['class'=>'my_class','id'=>'responsible_cd']) !!}</td>
                    <td data-label="数量">{!! Form::number('quantity[]',null,['class'=>'form-control text-center']) !!}</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <div class="button-panel">
        {!! Form::submit('出庫',['class'=>'btn']) !!}
        {!! Form::close() !!}
    </div>
@endsection
@push('css')
    <link href="{{ asset('css/middle-table.css') }}" rel="stylesheet">
@endpush

{{--
        <tbody class='form-group'>
            <tr>
                <td data-label="出庫日付">{!! Form::date('date',null,['class'=>'form-control text-center']) !!}</td>
                <td data-label="得意先コード">{!! Form::select('customer_code',$customers,null,['class'=>'form-control text-center']) !!}</td>
                <td data-label="品目コード">{!! Form::select('item_code',$items,null,['class'=>'form-control text-center']) !!}</td>
                <td data-label="数量">{!! Form::number('quantity',null,['class'=>'form-control text-center']) !!}</td>
            </tr>
        </tbody>
--}}