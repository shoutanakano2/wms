@extends('layouts.app2')
@section('content')
    <div class="form-wrapper">
        <h1>請求年月選択<br>(請求書発行)</h1>
        
        <div class='form'>
            {!! Form::open(['route'=>['customers.show',$customer->id],'method' =>'get']) !!}
                <h6 class='text-center'>発行する年月を選択して下さい。</h6>
                <div class = "form-group">
                    {{Form::selectRange('year', 2020, 2022, old('year'), ['class' => 'form-control', 'placeholder'=>'年'])}}
                </div>
                <div class = "form-group">
                    {{Form::selectRange('month', 1, 12, old('month'),['class' => 'form-control', 'placeholder'=>'月'])}}
                </div>
                <div class = "button-panel">
                    {!! Form::submit('表示',['class'=>'btn']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush 
