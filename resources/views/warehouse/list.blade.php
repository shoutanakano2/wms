@extends('layouts.app')

@section('content')
    <h1>倉庫マスタ一覧</h1>
        <ul class='list-instyled'>
           @foreach($warehouses as $warehouse)
                <li>
                    {!! $warehouse->warehouse_code !!}
                    {!! $warehouse->warehouse_name !!}
                    {!! link_to_route('warehouses.edit','編集',['id'=>$warehouse->id]) !!}
                    @if(Auth::id()==$warehouse->user_id)
                        {!! Form::open(['route'=>['warehouses.destroy','id'=>$warehouse->id],'method' =>'delete']) !!}
                            {!! Form::submit('削除',['class'=>'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    @endif
                </li>
            @endforeach
        </ul>
    {{ $warehouses->links('pagination::bootstrap-4') }}
@endsection




        
        