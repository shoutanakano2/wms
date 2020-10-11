@extends('layouts.app2')

@section('content')
    <h1 class="my-4">得意先マスタ一覧</h1>
        @if(session('flash_message'))
            <div class='flash_message alert alert-danger m-2' role='alert'>
                {{ session('flash_message') }}
            </div>
        @endif
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center">得意先コード</th>
                    <th scope="col" class="text-center">得意先名称'</th>
                    <th scope="col" class="text-center">得意先電話番号</th>
                    <th scope="col" class="text-center">得意先FAX番号</th>
                    <th scope="col" class="text-center">得意先Eメール</th>
                    <th scope="col" class="text-center">得意先郵便番</th>
                    <th scope="col" class="text-center">得意先住所</th>
                    <th scope="col" class="text-center">編集</th>
                    <th scope="col" class="text-center">削除</th>
                </tr>
            </thead>
            @foreach($customers as $customer)
                <tbody class="text-center">
                    <tr>
                        <td>{!! $customer->customer_code !!}</td>
                        <td>{!! $customer->customer_name !!}</td>
                        <td>{!! $customer->customer_phonenumber !!}</td>
                        <td>{!! $customer->customer_faxnumber !!}</td>
                        <td>{!! $customer->customer_email !!}</td>
                        <td>{!! $customer->customer_postalcode !!}</td>
                        <td>{!! $customer->customer_address !!}</td>
                        @if(Auth::id()==$customer->user_id)
                        <td>
                        {!! Form::open(['route'=>['customers.edit','id'=>$customer->id],'method' =>'get']) !!}
                            {!! Form::submit('編集',['class'=>'btn btn-outline-primary ']) !!}
                        {!! Form::close() !!}
                        </td>  
                        @endif
                        @if(Auth::id()==$customer->user_id)
                        <td>
                        {!! Form::open(['route'=>['customers.destroy','id'=>$customer->id],'method' =>'delete']) !!}
                            {!! Form::submit('削除',['class'=>'btn btn-outline-danger']) !!}
                        {!! Form::close() !!}
                        </td>
                        @endif
                    </tr>
                </tbody>
            @endforeach
        </table>

    {{ $customers->links('pagination::bootstrap-4') }}
@endsection