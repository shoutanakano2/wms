@extends('layouts.app')

@section('content')
    <h1>入出庫履歴照会</h1>
        <table border="1" >
            
            <thead>
                <tr>
                    <th>入出庫</th>
                    <th>入出庫日付</th>
                    <th>倉庫名称</th>
                    <th>品目名称</th>
                    <th>数量</th>
                </tr>
            </thead>
            @foreach($histories as $history)
                <tbody>
                    <tr>
                        @if($history->inout==1)
                            <td>{!! '入庫' !!}</td>
                        @else($history->inout==2)
                            <td>{!! '出庫'  !!}</td>
                        @endif
                            <td>{!! $history->date !!}</td>
                            <td>{!! $history->warehouse_name !!}</td>
                            <td>{!! $history->item_name !!}</td>
                            <td>{!! $history->quantity !!}</td>
                    </tr>
                </tbody>
            @endforeach
        </table>
        {!! Form::open(['route'=>['stocks.postCSV'],'method' =>'get']) !!}
        {!! Form::submit('CSV出力',['class'=>'btn btn-danger btn-sm']) !!}
        {!! Form::close() !!}
@endsection