@extends('layouts.app2')
@section('content')
    <h1>入出庫履歴照会</h1>
        <table border="1">
            <thead>
                <tr>
                    <th scope='col' class="text-center">入出庫</th>
                    <th scope='col' class="text-center">入出庫日付</th>
                    <th scope='col' class="text-center">倉庫名称</th>
                    <th scope='col' class="text-center">品目名称</th>
                    <th scope='col' class="text-center">数量</th>
                    <th scope='col' class="text-center">削除</th>
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
                        @if(Auth::id()==$history->user_id)
                            <td data-label="削除">
                                {!! Form::open(['route'=>['histories.delete','id'=>$history->id],'method' =>'delete']) !!}
                                    {!! Form::submit('削除',['class'=>'btn btn-outline-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                    </tr>
                </tbody>
            @endforeach
        </table>
        
        <div class='align-items-center'>
            {{ $histories->links('pagination::bootstrap-4') }}
        </div>
    
        <div class='button-panel'>
            {!! Form::open(['route'=>['histories.CSV','id' => $id],'method' =>'get']) !!}
            {!! Form::submit('CSV出力',['class'=>'btn btn-success btn-sm']) !!}
            {!! Form::close() !!}
        </div>
        
        {{--<div class='d-flex flex-row'>
            <div class='p-2'>
                {!! Form::open(['route'=>['histories.PDF','id' => $id],'method' =>'get' ]) !!}
                {!! Form::submit('PDF出力',['class'=>'btn btn-info btn-sm']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        --}}
        
@endsection
@push('css')
    <link href="{{ asset('css/middle-table.css') }}" rel="stylesheet">
@endpush