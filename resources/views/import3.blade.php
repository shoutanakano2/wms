@extends('layouts.app2')
@section('content')
    <div class='container'>
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
<form role='form' method='post' action = 'import', 'class' ='', files = true >
 {{ csrf_field() }}
<div class="form-group">
     <input type="file" class="" name="file" value="">
</div>
 
<button type="submit">csv読み込み</button>
 
</form>            
            
            

            
        </div>
    </div>
@endsection
 

            <form role='form' method='post' action='import' enctype='multipart/form-data'>
                {{ csrf_field() }}
                <input type='file' name='csv_file' id='csv_file'>
                <div class='form-group'>
                    <button type='submit' class='btn btn-default btn-success'>保存</button>
                </div>
            </form>