@extends('layouts.pdf')
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

@endsection