@extends('layouts.app2')
@section('content')
    <h1>入庫処理<p>(倉庫名称: {!! $warehouse->warehouse_code !!})</p></h1>
    {{--<p>(倉庫名称: {!! $warehouse->warehouse_code !!})</p>--}}
    {!! Form::open(['route'=>['stocks.matching',$warehouse->id]]) !!}
    {{ csrf_field() }}
    <table border='1'>
    {{--<table class='table table-striped' border='1'>--}}
        <thead>
            <tr>
                <th scope="col" class="text-center">入庫日付</th>
                <th scope="col" class="text-center">仕入先コード</th>
                <th scope="col" class="text-center">品目コード</th>
                <th scope="col" class="text-center">数量</th>
            </tr>
        </thead>
        <tbody class='form-group'>
            @for($i = 0 ; $i < 3; $i ++)
                <tr>
                    <td data-label="入庫日付">{!! Form::date('date[]',null,['class'=>'form-control text-right']) !!}</td>
                    <td data-label="仕入先コード">{!! Form::select('customer_code['.$i.']', $customersArray,old('customer_code['.$i.']'), ['class' => 'my_class','id' => 'responsible_cd']) !!}</td>
                    <td data-label="品目コード">{!! Form::select('item_code[]', $itemsArray,null, ['class' => 'my_class','id' => 'responsible_cd']) !!}</td>
                    <td data-label="数量">{!! Form::number('quantity[]',null,['class'=>'form-control text-right']) !!}</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <div class="button-panel">
        {!! Form::submit('入庫',['class'=>'btn']) !!}
        {!! Form::close() !!}
    </div>

@endsection
@push('css')
    <link href="{{ asset('css/middle-table.css') }}" rel="stylesheet">
@endpush