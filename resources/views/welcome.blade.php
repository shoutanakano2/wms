@extends('layouts.app')
@section('content')
    <div class='text-center'>
        <h1>倉庫管理システム</h1>
        {!! link_to_route('signup.get','会員登録',[],['class'=>'btn btn-lg btn-primary']) !!}
    </div>
@endsection