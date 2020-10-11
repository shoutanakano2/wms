@extends('layouts.app')
@yield('menu')
@section('content')
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
    
        
      
@endsection
    
    