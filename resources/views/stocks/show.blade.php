@extends('layouts.app2')
@section('content')
    <h1 class='my-4'>在庫照会</h1>
        <table class="table table-striped " border="1">
            <thead>
                <tr>
                    <th scope='col'>倉庫名称</th>
                    <th scope='col'>品目名称</th>
                    <th scope='col'>数量</th>
                </tr>
            </thead>
            @foreach($inoutDatas as $inoutData)
                <tbody>
                    <tr>
                        <td>{!! $inoutData['wareHouse'] !!}</td>
                        <td>{!! $inoutData['item'] !!}</td>
                        <td>{!! $inoutData['sum'] !!}</td>
                    </tr>
                </tbody>
            @endforeach
        </table>
        <div class='d-flex flex-row'>
            <div class='p-2'>
                {!! Form::open(['route'=>['stocks.CSV','id' => $id],'method' =>'get']) !!}
                {!! Form::submit('CSV出力',['class'=>'btn btn-success btn-sm']) !!}
                {!! Form::close() !!}
            </div>
            <div class='p-2'>
                {!! Form::open(['route'=>['stocks.PDF', 'id' => $id],'method' =>'get' ]) !!}
                {!! Form::submit('PDF出力',['class'=>'btn btn-info btn-sm']) !!}
                {!! Form::close() !!}
            </div>
        </div>
@endsection