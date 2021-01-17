@extends('layouts.app2')
@section('content')
    <div class='text-center my-4'>
        <h1>請求書発行</h1>
    </div>
    <h2 class='my-4'>請求年月選択</h2>
        <div class='col-sm-6 offset-sm-3'>
            {!! Form::open(['route'=>['customers.show',$customer->id],'method' =>'get']) !!}
                <h6>作成したい請求書の年月を選択して下さい。</h6>
                {{Form::selectRange('year', 2020, 2021, old('year'), ['class' => 'form-control', 'placeholder'=>'年'])}}
                {{Form::selectRange('month', 1, 12, old('month'),['class' => 'form-control', 'placeholder'=>'月'])}}
                {!! Form::submit('表示',['class'=>'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
 
@endsection
 
