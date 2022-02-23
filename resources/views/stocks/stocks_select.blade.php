@extends('layouts.app2')
@section('content')
    <h1>倉庫選択(在庫照会)</h1>
        <table border="1">
            <thead>
                <tr>
                    <th scope="col" class="text-center">倉庫コード</th>
                    <th scope="col" class="text-center">倉庫名称</th>
                </tr>
            </thead>
            @foreach($warehouses as $warehouse)
               <tbody class="text-center">
                    <tr>
                        <td data-label="倉庫コード">
                            {!! Form::open(['route'=>['stocks.show','id'=>$warehouse->id],'method' =>'get']) !!}
                                {!! Form::hidden('warehouse_code', $warehouse->warehouse_code) !!}
                                {!! Form::submit($warehouse->warehouse_code,['class'=>'btn btn-outline-dark btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td data-label="倉庫名称">
                            {!! $warehouse->warehouse_name !!}
                        </td>
                    </tr>
                </tbody>
            @endforeach
    {{ $warehouses->links('pagination::bootstrap-4') }}
@endsection
@push('css')
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
@endpush