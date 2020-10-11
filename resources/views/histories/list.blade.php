@extends('layouts.app2')
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
                    <th scope='col'>削除</th>
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
                        @if(Auth::id()==$history->user_id)
                            <td>
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
    
        <div class='d-flex flex-row'>
            <div class='p-2'>
                {!! Form::open(['route'=>['histories.CSV','id' => $id],'method' =>'get']) !!}
                {!! Form::submit('CSV出力',['class'=>'btn btn-success btn-sm']) !!}
                {!! Form::close() !!}
            </div>
            <div class='p-2'>
                {!! Form::open(['route'=>['histories.PDF', 'id' => $id],'method' =>'get' ]) !!}
                {!! Form::submit('PDF出力',['class'=>'btn btn-info btn-sm']) !!}
                {!! Form::close() !!}
            </div>
        </div>
@endsection