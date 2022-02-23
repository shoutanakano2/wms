@extends('layouts.app2')
@section('content')
    <div class='form-wrapper'>
        <h1>一括入出庫処理</h1>
        <h4>CSVファイルを選択して下さい</h4>
        
        <div class = "form">
            {{Form::open(['url' => route('stocks.import'), 'method' => 'post','enctype' => 'multipart/form-data'])}}
                {{ csrf_field() }}
                <input type='file' name='csv_file' id='csv_file'>
                <div class='button-panel'>
                    <button type='submit' class='btn'>保存</button>
                </div>
            {{Form::close()}}
        </div>
    </div>
    
        {{--<div class='container'>
        <div class='content'>
            <div class='title'>
                一括入出庫処理
            </div>
            <h4>CSVファイルを選択してください</h4>
            <div class='row'>
                <div class='col-xl-6'>
                    ■手順
 
                    1. CSVで保存します。
 
                    2. ファイルを選択し読み込んでください。
                </div>
            </div>
            {{Form::open(['url' => route('stocks.import'), 'method' => 'post','enctype' => 'multipart/form-data'])}}
            <!-- <form role='form' method='post' action='import' enctype='multipart/form-data'> -->
                {{ csrf_field() }}
                <input type='file' name='csv_file' id='csv_file'>
                <div class='form-group'>
                    <button type='submit' class='btn btn-default btn-success'>保存</button>
                </div>
            <!-- </form> -->
            {{Form::close()}}
        </div>
    </div>--}}
@endsection
@push('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush