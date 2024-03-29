@extends('layouts.app2')
@section('content')
    <h1>倉庫マスタ一覧</h1>
    <table border="1">
        <thead>
            <tr>
                <th scope="col" class="text-center">倉庫コード</th>
                <th scope="col" class="text-center">倉庫名称</th>
                <th scope="col" class="text-center">編集</th>
                <th scope="col" class="text-center">削除</th>
            </tr>
        </thead>
        @foreach($warehouses as $warehouse)
            <tbody class="text-center">
                <tr>
                    <td data-label="倉庫コード">{!! $warehouse->warehouse_code !!}</td>
                    <td data-label="倉庫名称">{!! $warehouse->warehouse_name !!}</td>
                    @if(Auth::id()==$warehouse->user_id)
                        <td data-label="編集">
                            {!! Form::open(['route'=>['warehouses.edit','id'=>$warehouse->id],'method' =>'get']) !!}
                            {!! Form::submit('編集',['class'=>'btn btn-outline-primary ']) !!}
                            {!! Form::close() !!}
                        </td>
                    @endif
                    @if(Auth::id()==$warehouse->user_id)
                        <td data-label="削除">
                            {!! Form::open(['route'=>['warehouses.destroy','id'=>$warehouse->id],'method' =>'delete']) !!}
                            {!! Form::submit('削除',['class'=>'btn btn-outline-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                    @endif
                </tr>
            </tbody>
        @endforeach
    </table>
    <ul class='list-instyled'>
    {{ $warehouses->links('pagination::bootstrap-4') }}
    
    {{--<h1 class="my-4">倉庫マスタ一覧</h1>
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center">倉庫コード</th>
                    <th scope="col" class="text-center">倉庫名称</th>
                    <th scope="col" class="text-center">編集</th>
                    <th scope="col" class="text-center">削除</th>
                </tr>
            </thead>
            @foreach($warehouses as $warehouse)
                <tbody class="text-center">
                    <tr>
                        <td>{!! $warehouse->warehouse_code !!}</td>
                        <td>{!! $warehouse->warehouse_name !!}</td>
                        @if(Auth::id()==$warehouse->user_id)
                            <td>
                                {!! Form::open(['route'=>['warehouses.edit','id'=>$warehouse->id],'method' =>'get']) !!}
                                {!! Form::submit('編集',['class'=>'btn btn-outline-primary ']) !!}
                                {!! Form::close() !!}
                            </td>  
                        @endif
                        @if(Auth::id()==$warehouse->user_id)
                            <td>
                                {!! Form::open(['route'=>['warehouses.destroy','id'=>$warehouse->id],'method' =>'delete']) !!}
                                {!! Form::submit('削除',['class'=>'btn btn-outline-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                    </tr>
                </tbody>
            @endforeach
        </table>
        <ul class='list-instyled'>
    {{ $warehouses->links('pagination::bootstrap-4') }}--}}
@endsection
@push('css')
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
@endpush



        
        