@extends('layouts.app')
@section('content')
    <h1 class="my-4">入出庫履歴照会</h1>
        <table class="table table-striped" border="1" >
            <thead>
                <tr>
                    <th scope='col'>入出庫</th>
                    <th scope='col'>入出庫日付</th>
                    <th scope='col'>倉庫名称</th>
                    <th scope='col'>品目名称</th>
                    <th scope='col'>数量</th>
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
@endsection