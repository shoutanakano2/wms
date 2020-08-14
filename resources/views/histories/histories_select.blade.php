@extends('layouts.app')

@section('content')
    <h1>倉庫選択</h1>
        <ul class='list-instyled'>
           @foreach($warehouses as $warehouse)
                <li>
                    {!! Form::open(['route'=>['stocks.history','id'=>$warehouse->id],'method' =>'get']) !!}
                        {!! Form::hidden('warehouse_code', $warehouse->warehouse_code) !!}
                        {!! Form::submit($warehouse->warehouse_code,['class'=>'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                    {!! $warehouse->warehouse_name !!}
                    
                </li>
            @endforeach
        </ul>
    {{ $warehouses->links('pagination::bootstrap-4') }}
@endsection