@extends('layouts.app2')
@section('content')
    <div class='form-wrapper'>
        <h1>得意先マスタ登録</h1>

        <div class='form'>
            {!! Form::open(['route'=>'customers.store']) !!}
                <div class='form-group'>
                    {!! Form::text('customer_code',old('customer_code'),['class'=>'form-control','placeholder'=>'得意先コード']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('customer_name',old('customer_name'),['class'=>'form-control','placeholder'=>'得意先名称']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::tel('customer_phonenumber',old('customer_phonenumber'),['class'=>'form-control','placeholder'=>'得意先電話番号']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::tel('customer_faxnumber',old('customer_faxnumber'),['class'=>'form-control','placeholder'=>'得意先FAX番号']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::email('customer_email',old('customer_email'),['class'=>'form-control','placeholder'=>'得意先Eメール']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::text('customer_postalcode',null,['class'=>'form-control','id'=>'zipcode','maxlength'=>'7','placeholder'=>'得意先郵便番号']) !!}
                </div>
                <p>※7桁の半角数字で入力してください</p>
                    <input type="button" id="search_btn" value="検索">
                    <div id="zip_result"></div>
                <div class='form-group'>
                    {!! Form::text('customer_address',old('customer_address'),['class'=>'form-control','id'=>'zipname','placeholder'=>'得意先住所']) !!}
                </div>
                <div class = "button-panel">
                    {!! Form::submit('登録',['class'=>'btn btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    {{-- <div class='text-center my-4'>
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
                    {!! Form::label('customer_postalcode','郵便番号') !!}
                    {!! Form::text('customer_postalcode',null,['class'=>'form-control','id'=>'zipcode','maxlength'=>'7']) !!}
                    

                </div>
                <p>※7桁の半角数字で入力してください</p>
                    <input type="button" id="search_btn" value="検索">
                    <div id="zip_result"></div>
                <div class='form-group'>
                    {!! Form::label('customer_address','得意先住所') !!}
                    {!! Form::text('customer_address',old('customer_address'),['class'=>'form-control','id'=>'zipname']) !!}
                </div>
                {!! Form::submit('登録',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>--}}
@endsection
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush