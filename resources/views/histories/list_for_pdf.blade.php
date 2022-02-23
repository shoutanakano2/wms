@extends('layouts.pdf')
@section('content')
    <h1>入出庫履歴照会</h1>
        <table border="1" >
            <thead>
                <tr>
                    <th scope='col' class="text-center">入出庫</th>
                    <th scope='col' class="text-center">入出庫日付</th>
                    <th scope='col' class="text-center">倉庫名称</th>
                    <th scope='col' class="text-center">品目名称</th>
                    <th scope='col' class="text-center">数量</th>
                </tr>
            </thead>
            @foreach($histories as $history)
                <tbody>
                    <tr>
                        @if($history->inout==1)
                            <td data-label="入出庫">{!! '入庫' !!}</td>
                        @else($history->inout==2)
                            <td data-label="入出庫">{!! '出庫'  !!}</td>
                        @endif
                            <td data-label="入出庫日付">{!! $history->date !!}</td>
                            <td data-label="倉庫名称">{!! $history->warehouse_name !!}</td>
                            <td data-label="品目名称">{!! $history->item_name !!}</td>
                            <td data-label="数量">{!! $history->quantity !!}</td>
                    </tr>
                </tbody>
            @endforeach
@endsection
@push('css')
    <link href="{{ asset('css/middle-table.css') }}" rel="stylesheet">
@endpush