@extends('layouts.app2')
@section('content')
    <h1>顧客選択(請求書発行)</h1>
        <table border="1">
            <thead>
                <tr>
                    <th scope="col" class="text-center">顧客コード</th>
                    <th scope="col" class="text-center">顧客名称</th>
                </tr>
            </thead>
           @foreach($customers as $customer)
               <tbody class="text-center">
                    <tr>
                        <td data-label="顧客コード">
                            {!! Form::open(['route'=>['customers.month_select','id'=>$customer->id],'method' =>'get']) !!}
                                {!! Form::hidden('customer_code', $customer->customer_code) !!}
                                {!! Form::submit($customer->customer_code,['class'=>'btn btn-outline-dark btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td data-label="顧客名称">
                            {!! $customer->customer_name !!}
                        </td>
                    </tr>
                </tbody>
            @endforeach
    {{ $customers->links('pagination::bootstrap-4') }}
@endsection
@push('css')
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">
@endpush