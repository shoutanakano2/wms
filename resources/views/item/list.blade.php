@extends('layouts.app2')

@section('content')
    <h1>品目マスタ一覧</h1>
        <table border="1">
            <thead>
                <tr>
                    <th scope="col" class="text-center">品目コード</th>
                    <th scope="col" class="text-center">品目名称</th>
                    <th scope="col" class="text-center">売値</th>
                    <th scope="col" class="text-center">仕入値</th>
                    <th scope="col" class="text-center">編集</th>
                    <th scope="col" class="text-center">削除</th>
                </tr>
            </thead>
            @foreach($items as $item)
                <tbody class="text-center">
                    <tr>
                        <td data-label="品目コード">{!! $item->item_code !!}</td>
                        <td data-label="品目名称">{!! $item->item_name !!}</td>
                        <td data-label="売値">{!! $item->sell_price !!}</td>
                        <td data-label="仕入値">{!! $item->purchase_price !!}</td>
                        @if(Auth::id()==$item->user_id)
                            <td data-label="編集">
                                {!! Form::open(['route'=>['items.edit','id'=>$item->id],'method' =>'get']) !!}
                                    {!! Form::submit('編集',['class'=>'btn btn-outline-primary ']) !!}
                                {!! Form::close() !!}
                            </td>  
                        @endif
                        @if(Auth::id()==$item->user_id)
                            <td data-label="削除">
                                {!! Form::open(['route'=>['items.destroy','id'=>$item->id],'method' =>'delete']) !!}
                                    {!! Form::submit('削除',['class'=>'btn btn-outline-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                    </tr>
                </tbody>
            @endforeach
        </table>

    {{ $items->links('pagination::bootstrap-4') }}
{{--    <h1 class="my-4">品目マスタ一覧</h1>
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center">品目コード</th>
                    <th scope="col" class="text-center">品目名称</th>
                    <th scope="col" class="text-center">売値</th>
                    <th scope="col" class="text-center">仕入値</th>
                    <th scope="col" class="text-center">編集</th>
                    <th scope="col" class="text-center">削除</th>
                </tr>
            </thead>
            @foreach($items as $item)
                <tbody class="text-center">
                    <tr>
                        <td>{!! $item->item_code !!}</td>
                        <td>{!! $item->item_name !!}</td>
                        <td>{!! $item->sell_price !!}</td>
                        <td>{!! $item->purchase_price !!}</td>
                        @if(Auth::id()==$item->user_id)
                        <td>
                        {!! Form::open(['route'=>['items.edit','id'=>$item->id],'method' =>'get']) !!}
                            {!! Form::submit('編集',['class'=>'btn btn-outline-primary ']) !!}
                        {!! Form::close() !!}
                        </td>  
                        @endif
                        @if(Auth::id()==$item->user_id)
                        <td>
                        {!! Form::open(['route'=>['items.destroy','id'=>$item->id],'method' =>'delete']) !!}
                            {!! Form::submit('削除',['class'=>'btn btn-outline-danger']) !!}
                        {!! Form::close() !!}
                        </td>
                        @endif
                    </tr>
                </tbody>
            @endforeach
        </table>

    {{ $items->links('pagination::bootstrap-4') }}--}}
@endsection
@push('css')
    <link href="{{ asset('css/middle-table.css') }}" rel="stylesheet">
@endpush