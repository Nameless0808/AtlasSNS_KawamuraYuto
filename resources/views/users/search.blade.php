@extends('layouts.login')

@section('content')

<div class="search-form">
    <form id="search-form" action="/search_result" method="get">
        <div class="search-container">
            <div class="search-input">
                <input type="text" id="search-query" name="query" placeholder="ユーザー名">
                <button type="submit">
                    <img src="/images/search.png" alt="search">
                </button>
            </div>
            <div class="search-word"></div>
        </div>
    </form>
    <div id="search-results">
        @foreach($users as $user)
            <div class="user search-results-page">
                <div class="user-info-v2">
                    @if (Str::startsWith($user->images, 'https://') || Str::startsWith($user->images, 'http://'))
                        <!-- アイコンがURLの場合 -->
                        <img src="{{ $user->images }}" alt="User Image" class="user-image">
                    @else
                        <!-- アイコンがローカルストレージの場合 -->
                        <img src="{{ asset('storage/' . $user->images) }}" alt="User Image" class="user-image">
                    @endif
                    <span>{{ $user->username }}</span>
                </div>
                @if (Auth::user()->isFollowing($user->id))
                    <div class="button-container">
                        <button type="button" class="unfollow-button left-align-button" data-user-id="{{ $user->id }}">フォロー解除</button>
                    </div>
                @else
                    <div class="button-container">
                        <button type="button" class="follow-button left-align-button" data-user-id="{{ $user->id }}">フォローする</button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>



<script>
$(document).ready(function() {
    // CSRFトークンの設定
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // フォローとフォロー解除のイベント設定
    function setFollowEvents() {
        $('.follow-button').click(function(event) {
            event.preventDefault();
            var userId = $(this).data('user-id');
            var button = $(this);

            $.ajax({
                url: '/follow',
                method: 'POST',
                data: { id: userId },
                success: function() {
                    location.reload();
                }
            });
        });

        $('.unfollow-button').click(function(event) {
            event.preventDefault();
            var userId = $(this).data('user-id');
            var button = $(this);

             $.ajax({
                url: '/unfollow',
                method: 'POST',
                data: { id: userId },
                success: function() {
                   location.reload();
                }
            });
        });
    }

    // 検索フォームの送信時のイベント設定
    $('#search-form').on('submit', function(e) {
        e.preventDefault(); // フォームのデフォルトの送信動作をキャンセル

        var query = $('#search-query').val();  // 検索クエリを取得

        $.ajax({
            url: '/search_result',
            method: 'GET',
            data: { query: query },
            success: function(data) {
                // 検索結果を表示
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<div class="user">';
                    html += '<div class="user-info">';  // この行を追加
                    if (data[i].avatar) {
                        html += '<img src="' + data[i].avatar + '" alt="User Image" class="user-image">';
                    } else {
                        // avatarプロパティが存在しない場合、またはnullやundefinedである場合、デフォルトのアイコンを表示
                        html += '<img src="/images/icon1.png" alt="User Image" class="user-image">';
                    }
                    html += '<span>' + data[i].name + '</span>';
                    html += '</div>';  // この行を追加
                    // フォローボタンを追加
                     html += '<div class="button-container">'; // この行を追加
                    if (data[i].isFollowing) {
                        html += '<button class="unfollow-button centered-button " data-user-id="' + data[i].id + '">フォロー解除</button>';
                    } else {
                        html += '<button class="follow-button centered-button" data-user-id="' + data[i].id + '">フォローする</button>';
                    }
                    html += '</div>';
                    html += '</div>';
                }
                $('#search-results').html(html);
                // 検索ワードを表示
                $('.search-word').text('検索ワード: ' + query);

        // ボタンのイベントを設定
        setFollowEvents();
    }
    });
 });

    // 初期化時のボタンイベントを設定
    setFollowEvents();
});

</script>

@endsection
