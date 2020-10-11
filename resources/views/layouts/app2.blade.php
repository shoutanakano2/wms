<!DOCTYPE html>
<html lang="ja" class='mh-100'>
    <head>
        <meta charset="utf-8">
        <title>wms</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/wms.css">
    </head>

    <body class='container-fluid p-0 mh-100'>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark col-xl-12">
            <a class='navbar-brand' href='#'>倉庫管理システム</a>
            <button class="navbar-togger" type="button" data-togger="collapse" data-target="navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-togger-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        <a class="nav-link" href="/logout">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container col-xl-12 fullheight p-0 m-0">
            <div class="row hmax m-0 p-0">
                <div class="col-xl-2 bg-secondary p-0 m-0">
                    <div class='text-center m-4 p-0'>
                        @if(Auth::check())
                            <h5 class='m-0 p-0'>メインメニュー</h5>
                             <h5 class="m-3">１.マスタ関連</h5>
                                <div class='h6 m-2'>
                                    ①
                                    {!! link_to_route('warehouses.create','倉庫マスタ作成',[]) !!}
                                    /
                                    {!! link_to_route('warehouses.index','一覧', []) !!}
                                </div>
                                <div class='h6 m-2'>
                                    ②
                                    {!! link_to_route('items.create','品目マスタ作成',[]) !!}
                                    /
                                    {!! link_to_route('items.index','一覧',[]) !!}
                                </div>
                                <div class='h6 m-2'>
                                    ③
                                    {!! link_to_route('customers.create','得意先マスタ作成',[]) !!}
                                    /
                                    {!! link_to_route('customers.list','一覧',[]) !!}
                                </div>
                            <h5 class='m-3'>２.入出庫処理</h5>
                                <div class='h6 m-2'>
                                    ①
                                    {!! link_to_route('warehouses.inselect','入庫処理',[]) !!}
                                </div>
                                <div class='h6 m-2'>
                                    ②
                                    {!! link_to_route('warehouses.outselect','出庫処理',[]) !!}
                                </div>
                                <div class='h6 m-2'>
                                    ③
                                    {!! link_to_route('stocks.inoutfile','一括処理',[]) !!}
                                </div>

                            <h5 class='m-3'>３.在庫管理</h5>
                                <div class='h6 m-2'>
                                    ①
                                    {!! link_to_route('warehouses.stocksSelect','在庫照会   ',[]) !!}
                                </div>
                                <div class='h6 m-2'>
                                    ②
                                    {!! link_to_route('warehouses.historiesSelect','入出庫履歴照会',[]) !!}
                                </div>
                            <h6 class='m-3'>請求書</h6>
                                <div class='h6 m-2'>
                                    ①
                                    {!! link_to_route('customers.index','請求書発行',[]) !!}
                                </div>
                        @else
                            <h2 class="m-4">倉庫管理<br>システム</h2>
                            <div class='m-3'>
                                {!! link_to_route('signup.get','会員登録',[],['class'=>'btn btn-lg btn-primary']) !!}
                            </div>
                            <div class='m-3'>
                                {!! link_to_route('login','ログイン',[],['class'=>'btn btn-lg btn-primary']) !!}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-10 p-0 bg-info">
                    @include('commons.error_messages')
                    @yield('content')
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    </body>
</html>