@extends('layouts.app')
@section('content')
    
    {{--レイアウト変更のため一旦退避
    <div class='text-center my-4'>
        <h1>ログイン</h1>
    </div>
    <div class='row my-3'>
        <div class='col-sm-6  offset-sm-3'>
            {!! Form::open(['route'=>'login.post']) !!}
                <div class='form-group'>
                    {!! Form::label('email','メール') !!}
                    {!! Form::email('email',old('email'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group'>
                    {!! Form::label('password','パスワード') !!}
                    {!! Form::password('password',['class'=>'form-control']) !!}
                </div>
                {!! Form::submit('ログイン',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <div class='text-center'>
        {!! link_to_route('signup.get','会員登録がお済でない方はこちら',[]) !!}
    </div> --}}
    
    <div class='form-wrapper'>
        <h1>ログイン</h1>
    
        <div class='form'>
            {!! Form::open(['route'=>'login.post']) !!}
                <div class='form-group'>
                    {{--{!! Form::label('email','メール') !!}--}}
                    {!! Form::email('email',old('email'),['class'=>'form-control','placeholder'=>'Eメール']) !!}
                </div>
                <div class='form-group'>
                    {{--{!! Form::label('password','パスワード') !!}--}}
                    {!! Form::password('password',['class'=>'form-control','placeholder'=>'パスワード']) !!}
                </div>
                <div class = "button-panel">
                    {!! Form::submit('ログイン',['class'=>'btn']) !!}
                </div>
            {!! Form::close() !!}
        </div>
        
        <div class='form-footer'>
            {!! link_to_route('signup.get','会員登録がお済でない方はこちら',['class'=>'footer-messege']) !!}
        </div>
    </div>
    
@endsection
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush