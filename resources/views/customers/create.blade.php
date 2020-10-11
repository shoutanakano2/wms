@extends('layouts.app2')
@section('content')
    <div class='text-center my-4'>
        <h1>得意先マスタ登録</h1>
    </div>
    <div class='row mt-4'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>'customers.store']) !!}
                <div class='form-group'>
                    {!! Form::label('customer_code','得意先コード') !!}
                    {!! Form::text('customer_code',old('customer_code'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_name','得意先名称') !!}
                    {!! Form::text('customer_name',old('customer_name'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_phonenumber','得意先電話番号') !!}
                    {!! Form::tel('customer_phonenumber',old('customer_phonenumber'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_faxnumber','得意先FAX番号') !!}
                    {!! Form::tel('customer_faxnumber',old('customer_faxnumber'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_email','得意先Eメール') !!}
                    {!! Form::email('customer_email',old('customer_email'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_postalcode','得意先郵便番号') !!}
                    {!! Form::number('customer_postalcode',old('customer_postalcode'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('customer_address','得意先住所') !!}
                    {!! Form::text('customer_address',old('customer_address'),['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('登録',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection