@extends('layouts.app2')
@section('content')
    <div class='text-center my-4'>
        <h1>請求書発行</h1>
    </div>
    <h2 class='my-4'>顧客選択</h2>
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center">顧客コード</th>
                    <th scope="col" class="text-center">顧客名称</th>
                </tr>
            </thead>
           @foreach($customers as $customer)
               <tbody class="text-center">
                    <tr>
                        <td>
                            {!! Form::open(['route'=>['customers.show','id'=>$customer->id],'method' =>'get']) !!}
                                {!! Form::hidden('customer_code', $customer->customer_code) !!}
                                {!! Form::submit($customer->customer_code,['class'=>'btn btn-outline-dark btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            {!! $customer->customer_name !!}
                        </td>
                    </tr>
                </tbody>
            @endforeach
    {{ $customers->links('pagination::bootstrap-4') }}
@endsection
