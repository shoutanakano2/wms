@extends('layouts.app2')

@section('content')
    <h1 class="my-4">倉庫選択</h1>
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center">倉庫コード</th>
                    <th scope="col" class="text-center">倉庫名称</th>
                </tr>
            </thead>
            
           @foreach($warehouses as $warehouse)
               <tbody class="text-center">
                    <tr>
                        <td>
                            {!! Form::open(['route'=>['warehouses.delete','id'=>$warehouse->id],'method' =>'get']) !!}
                                {!! Form::hidden('warehouse_code', $warehouse->warehouse_code) !!}
                                {!! Form::submit($warehouse->warehouse_code,['class'=>'btn btn-outline-dark btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    
                        <td>
                            {!! $warehouse->warehouse_name !!}
                        </td>
                    </tr>
                </tbody>
            @endforeach
        
    {{ $warehouses->links('pagination::bootstrap-4') }}
@endsection
