@extends('layouts.app')
@yield('menu')
@section('content')
    {{--レイアウト変更のため一旦退避
    <div class="text-center my-4">
        <h1>会員登録</h1>
    </div>
    <div class="row my-3 col-xl-12">
        <div class='col-xl-6 offset-xl-3 my-2'>
            {!! Form::open(['route'=>'signup.post']) !!}
                <div class='form-group my-2'>
                    {!! Form::label('name','会社名') !!}
                    {!! Form::text('name',old('name'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group my-2'>
                    {!! Form::label('email','メール') !!}
                    {!! Form::email('email',old('email'),['class'=>'form-control']) !!}
                </div>
                <div class='form-group my-2'>
                    {!! Form::label('password','パスワード') !!}
                    {!! Form::password('password',['class'=>'form-control']) !!}
                </div>
                <div class="my-2">
                    {!! Form::submit('登録',['class'=>'btn btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}
            
        </div>
      </div>
      <div class='text-center'>
        {!! link_to_route('login','会員登録済の方はこちら',[]) !!}
      </div>
     --}} 
    <div class="form-wrapper">
        <h1>会員登録</h1>
        
        <div class="form">
            {!! Form::open(['route'=>'signup.post']) !!}
                <div class='form-group'>
                    {{--{!! Form::label('name','会社名') !!}--}}
                    {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'会社名']) !!}
                </div>
                <div class='form-group'>
                    {{--{!! Form::label('email','メール') !!}--}}
                    {!! Form::email('email',old('email'),['class'=>'form-control','placeholder'=>'Eメール']) !!}
                </div>
                <div class='form-group'>
                    {{--{!! Form::label('password','パスワード') !!}--}}
                    {!! Form::password('password',['class'=>'form-control','placeholder'=>'パスワード']) !!}
                </div>
                <div class="button-panel">
                    {{--{!! Form::submit('登録',['class'=>'btn btn-primary btn-block']) !!}--}}
                    {!! Form::submit('登録',['class'=>'btn']) !!}
                </div>
            {!! Form::close() !!}
        </div>
          
        <div class='form-footer'>
            {!! link_to_route('login','会員登録済の方はこちら',['class'=>'footer-messege']) !!}
        </div>
    </div>
@endsection
{{--@section('pageCss')
    <link href = "css/register.css" rel="stylesheet">
@section--}}
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush
