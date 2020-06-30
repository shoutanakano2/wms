@extends('layouts.app')
@section('content')
    <div class='text-center'>
        <h1>出庫処理</h1>
    </div>
    <p>倉庫名称</p>
     {!! $warehouse->warehouse_code !!}

@endsection