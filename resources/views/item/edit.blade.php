@extends('layouts.app2')
@section('content')
    <div class='form-wrapper'>
        <h1>品目マスタ変更</h1>
    
        <div class='form'>
            {!! Form::open(['route'=>['items.update',$item->id],'method'=>'put']) !!}
                <div class='form-group'>
                    {!! Form::text('item_code',old('item_code',$item->item_code),['class'=>'form-control','placeholder'=>'品目コード']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('item_name',old('item_name',$item->item_name),['class'=>'form-control','placeholder'=>'品目名称']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('sell_price',old('sell_price',$item->sell_price),['class'=>'form-control','placeholder'=>'売値']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('purchase_price',old('purchase_price',$item->purchase_price),['class'=>'form-control','placeholder'=>'仕入値']) !!}
                </div>
                <div class = "button-panel">
                    {!! Form::submit('変更',['class'=>'btn']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    
    {{--    <div class='text-center'>
        <h1>品目マスタ変更</h1>
    
        <div class='row'>
            <div class='col-sm-6  offset-sm-3'>
                {!! Form::open(['route'=>['items.update',$item->id],'method'=>'put']) !!}
                    <div class='form-group'>
                        {!! Form::label('item_code','品目コード') !!}
                        {!! Form::text('item_code',old('item_code',$item->item_code),['class'=>'form-control']) !!}
                    </div>
                    <div class='form-group'>
                        {!! Form::label('item_name','品目名称') !!}
                        {!! Form::text('item_name',old('item_name',$item->item_name),['class'=>'form-control']) !!}
                    </div>
                    <div class='form-group'>
                        {!! Form::label('sell_price','売値') !!}
                        {!! Form::text('sell_price',old('sell_price',$item->sell_price),['class'=>'form-control']) !!}
                    </div>
                    <div class='form-group'>
                        {!! Form::label('purchase_price','仕入値') !!}
                        {!! Form::text('purchase_price',old('purchase_price',$item->purchase_price),['class'=>'form-control']) !!}
                    </div>
                    {!! Form::submit('変更',['class'=>'btn btn-primary btn-block']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>--}}
@endsection
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush