@extends('layouts.app')
@section('content')
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
    </div>
@endsection