<!DOCTYPE html>
<html lang="ja" class='mh-100'>
    <head>
        <meta charset="utf-8">
        <title>wms</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/wms.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="{{ asset('/js/javascript.js') }}"></script>
        @stack('css')
    </head>

    <body>
        <header class="navbar navbar-expand-lg navbar-dark bg-dark col-xl-12">
            <a class='navbar-brand' href='#'>倉庫管理システム</a>
            <button class="navbar-togger" type="button" data-togger="collapse" data-target="navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-togger-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        @if(Auth::check())
                            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                            <a class="nav-link" href="/logout">Logout</a>
                        @endif
                    </div>
                </div>
            </div>
        </header>
        
        {{--<div id = "container">
            <header id = "header">
                @if(Auth::check())
                    <h1>メニュー</h1>
                    <nav>
                        <ul>
                            <li><a href = "/">トップページ</a></li>
                            <li class="has-child"><a href = "#">マスタ関連</a>
                                <ul>
                                    <li><a href = "{{ route('warehouses.create')}}">倉庫マスタ作成</a></li>
                                    <li><a href = "{{ route('warehouses.index')}}">倉庫マスタ一覧</a></li>
                                    <li><a href = "{{ route('items.create')}}">品目マスタ作成</a></li>
                                    <li><a href = "{{ route('items.index')}}">品目マスタ一覧</a></li>
                                    <li><a href = "{{ route('customers.create') }}">得意先マスタ作成</a></li>
                                    <li><a href = "{{ route('customers.list') }}">得意先マスタ一覧</a></li>
                                </ul>
                            </li>
                            <li class = "has-child"><a href = "#">入出庫処理</a>
                                <ul>
                                    <li><a href = "{{ route('warehouses.inselect') }}">入庫処理</a></li>
                                    <li><a href = "{{ route('warehouses.outselect') }}">出庫処理</a></li>
                                    <li><a href = "{{ route('stocks.inoutfile') }}">一括処理</a></li>
                                </ul>
                            </li>
                            <li class = "has-child"><a href = "#">在庫管理</a>
                                <ul>
                                    <li><a href = "{{ route('warehouses.stocksSelect') }}">在照庫会</a></li>
                                    <li><a href = "{{ route('warehouses.historiesSelect') }}">入出庫履歴照会</a></li>
                                </ul>
                            </li>
                            <li><a href = "{{ route('customers.index') }}">請求書発行</a></li>
                        </ul>
                    </nav>
                @else
                                                           {{--<h2 class="m-4">倉庫管理<br>システム</h2>--}}
                    {{--<div class='m-3'>
                        {!! link_to_route('signup.get','会員登録',[],['class'=>'btn btn-lg btn-primary']) !!}
                    </div>
                    <div class='m-3'>
                        {!! link_to_route('login','ログイン',[],['class'=>'btn btn-lg btn-primary']) !!}
                    </div>
                @endif
            </header>
            <main id = "main-area">
                <section id = "area-1">
                    @if (session('flash_message'))
                        <div class='flash_message alert alert-danger m-2' role='alert'>
                            {{ session('flash_message') }}
                        </div>
                    @endif
                    @if (Session::has('message'))
                        <p>{{ session('message') }}</p>
                    @endif
                    @include('commons.error_messages')
                    @yield('content')
                </section>
            </main>
        </div>--}}
        @if(Auth::check())
            <div id = "container">
                <header id = "header">
                    <h1>メニュー</h1>
                    <nav>
                        <ul>
                            <li><a href = "/">トップページ</a></li>
                            <li class="has-child"><a href = "#">マスタ関連</a>
                                <ul>
                                    <li><a href = "{{ route('warehouses.create')}}">倉庫マスタ作成</a></li>
                                    <li><a href = "{{ route('warehouses.index')}}">倉庫マスタ一覧</a></li>
                                    <li><a href = "{{ route('items.create')}}">品目マスタ作成</a></li>
                                    <li><a href = "{{ route('items.index')}}">品目マスタ一覧</a></li>
                                    <li><a href = "{{ route('customers.create') }}">得意先マスタ作成</a></li>
                                    <li><a href = "{{ route('customers.list') }}">得意先マスタ一覧</a></li>
                                </ul>
                            </li>
                            <li class = "has-child"><a href = "#">入出庫処理</a>
                                <ul>
                                    <li><a href = "{{ route('warehouses.inselect') }}">入庫処理</a></li>
                                    <li><a href = "{{ route('warehouses.outselect') }}">出庫処理</a></li>
                                    <li><a href = "{{ route('stocks.inoutfile') }}">一括処理</a></li>
                                </ul>
                            </li>
                            <li class = "has-child"><a href = "#">在庫管理</a>
                                <ul>
                                    <li><a href = "{{ route('warehouses.stocksSelect') }}">在照庫会</a></li>
                                    <li><a href = "{{ route('warehouses.historiesSelect') }}">入出庫履歴照会</a></li>
                                </ul>
                            </li>
                            <li><a href = "{{ route('customers.index') }}">請求書発行</a></li>
                        </ul>
                    </nav>
                </header>
                <main id = "main-area">
                    <section id = "area-1">
                        @if (session('flash_message'))
                            <div class='flash_message text-center alert alert-danger m-2' role='alert'>
                                {{ session('flash_message') }}
                            </div>
                        @endif
                        @if (Session::has('message'))
                            <div class = "message bg-success text-center py-3 my-0">
                                <p>{{ session('message') }}</p>
                            </div>
                            
                        @endif
                        @include('commons.error_messages')
                        @yield('content')
                    </section>
                </main>
            </div>
        @else
            <div class = "container">
                        @if (session('flash_message'))
                            <div class='flash_message alert alert-danger m-2' role='alert'>
                                {{ session('flash_message') }}
                            </div>
                        @endif
                        @if (Session::has('message'))
                            <p>{{ session('message') }}</p>
                        @endif
                        @include('commons.error_messages')
                        @yield('content')

            </div>
            {{--
                    <div class='m-3'>
                        {!! link_to_route('signup.get','会員登録',[],['class'=>'btn btn-lg btn-primary']) !!}
                    </div>
                    <div class='m-3'>
                        {!! link_to_route('login','ログイン',[],['class'=>'btn btn-lg btn-primary']) !!}
                    </div>
            --}}
        @endif
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    </body>
</html>

     