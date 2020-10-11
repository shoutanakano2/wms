@extends('layouts.app2')
@section('content')
    <div class='text-center my-4'>
        <h1>得意先マスタ変更</h1>
    </div>
    <div class='row mt-4'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>['customers.update',$customer->id],'method'=>'put']) !!}
                <div class='form-group'>
                    {!! Form::label('customer_code','得意先コード') !!}
                    {!! Form::text('customer_code',$customer->customer_code,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_name','得意先名称') !!}
                    {!! Form::text('customer_name',$customer->customer_name,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_phonenumber','得意先電話番号') !!}
                    {!! Form::tel('customer_phonenumber',$customer->customer_phonenumber,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_faxnumber','得意先FAX番号') !!}
                    {!! Form::tel('customer_faxnumber',$customer->customer_faxnumber,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_email','得意先Eメール') !!}
                    {!! Form::email('customer_email',$customer->customer_email,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_postalcode','得意先郵便番号') !!}
                    {!! Form::number('customer_postalcode',$customer->customer_postalcode,['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_address','得意先住所') !!}
                    {!! Form::text('customer_address',$customer->customer_address,['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('変更',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection