@extends('layouts.app2')
@section('content')
    <h1>在庫照会</h1>
        <table border="1">
            <thead>
                <tr>
                    <th scope='col' class="text-center">倉庫名称</th>
                    <th scope='col' class="text-center">品目名称</th>
                    <th scope='col' class="text-center">数量</th>
                </tr>
            </thead>
            @foreach($inoutDatas as $inoutData)
                @if($inoutData['wareHouse'] != '')
                    <tbody>
                        <tr>
                            <td data-label="倉庫名称">{!! $inoutData['wareHouse'] !!}</td>
                            <td data-label="品目名称">{!! $inoutData['item'] !!}</td>
                            <td data-label="数量">{!! $inoutData['sum'] !!}</td>
                        </tr>
                    </tbody>
                @endif
            @endforeach
        </table>
        
        {{--<div class='align-items-center'>
            {{ $inoutDatas->links('pagination::bootstrap-4') }}
        </div>--}}
        
        <div class='button-panel'>
            {!! Form::open(['route'=>['stocks.CSV','id' => $id],'method' =>'get']) !!}
            {!! Form::submit('CSV出力',['class'=>'btn btn-success btn-sm']) !!}
            {!! Form::close() !!}
        </div>
        {{--
        <div class='d-flex flex-row'>
            <div class='p-2'>
                {!! Form::open(['route'=>['stocks.PDF', 'id' => $id],'method' =>'get' ]) !!}
                {!! Form::submit('PDF出力',['class'=>'btn btn-info btn-sm']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        --}}
@endsection
@push('css')
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
@endpush