@extends('layouts.app')

@section('content')
    <h1>品目マスタ一覧</h1>
        <ul class='list-instyled'>
           @foreach($items as $item)
                <li>
                    {!! $item->item_code !!}
                    {!! $item->item_name !!}
                    {!! link_to_route('items.edit','編集',['id'=>$item->id]) !!}
                    @if(Auth::id()==$item->user_id)
                        {!! Form::open(['route'=>['items.destroy','id'=>$item->id],'method' =>'delete']) !!}
                            {!! Form::submit('削除',['class'=>'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    @endif
                </li>
            @endforeach
        </ul>
    {{ $items->links('pagination::bootstrap-4') }}
@endsection
