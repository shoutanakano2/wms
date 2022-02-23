<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>wms</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        @yield('pageCss')
        @stack('css')
    </head>

    <body class='bg-info'>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
        <div class="container">
            @include('commons.error_messages')
            @yield('content')
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    </body>
</html>