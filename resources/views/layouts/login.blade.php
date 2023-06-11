<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <!-- メタタグ -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->

    <!-- Bootstrap CSS -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- jQuery library -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- Popper JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->
    <!-- Bootstrap JS -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>






</head>
<body>
    <header>
        <div id="head" class="header-container">
            <div class="logo">
                <h1><a href="/top"><img src="{{ asset('images/atlas.png') }}"></a></h1>

            </div>

            @if(Auth::check())
                <div class="current-user">
                <img src="{{ asset('storage/' . Auth::user()->images) }}" alt="User Image" class="user-image">
                <span>{{ Auth::user()->username }}さん</span>
                </div>
            @endif

            <div class="dropdown-container">
                <div class="container">
                    <div class="accordion" id="headerAccordion">
                        <div class="card">
                            <div class="card-header" id="headerMenu">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true" aria-controls="collapseMenu">
                                        <span class="arrow">&#x25BC;</span>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseMenu" class="collapse" aria-labelledby="headerMenu" data-parent="#headerAccordion">
                                <div class="card-body">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/top">HOME</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/profile">プロフィール編集</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/logout">ログアウト</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <div id="row">
        <div id="container">
            @yield('content')
        </div >
        <div id="side-bar">
            <div id="confirm">
                <h2>{{ Auth::user()->name }}</h2>
                <div>
                    <p>フォロー数: {{ Auth::user()->followings->count() }}</p>
                </div>
                <p class="btn"><a href="/followList">フォローリスト</a></p>
                <div>
                    <p>フォロワー数: {{ Auth::user()->followers->count() }}</p>
                </div>
                <p class="btn"><a href="/followerList">フォロワーリスト</a></p>
            </div>
            <p class="btn"><a href="/search">ユーザー検索</a></p>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $('#headerAccordion').on('show.bs.collapse', function () {
            $('.arrow').removeClass('arrow-down').addClass('arrow-up');
        });
        $('#headerAccordion').on('hide.bs.collapse', function () {
            $('.arrow').removeClass('arrow-up').addClass('arrow-down');
        });
    });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @stack('scripts')
</body>
</html>
