@extends('layouts.app')

@section('content')
    <h1>在庫照会</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>倉庫名称</th>
                    <th>品目名称</th>
                    <th>数量</th>
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
        </ul>
@endsection