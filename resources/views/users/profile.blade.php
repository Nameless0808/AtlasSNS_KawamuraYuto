@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                <div class="card mb-4 shadow-sm">
                    <img class="bd-placeholder-img card-img-top" src="{{ asset('storage/' . $user->images) }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->username }}</h5>
                        <p class="card-text">{{ $user->bio }}</p> <!--自己紹介 -->
                        <!-- 自分の場合 -->
                        @if (Auth::user()->id == $user->id)
                        <!-- 編集フォーム -->
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="username">user name</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                                </div>

                                <div class="form-group">
                                    <label for="mail">mail adress</label>
                                    <input type="mail" class="form-control" id="mail" name="mail" value="{{ $user->mail }}">
                                </div>

                                <div class="form-group">
                                    <label for="password">password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">password comfirm</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>

                                <div class="form-group">
                                    <label for="bio">bio</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3">{{ $user->bio }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="images">icon image</label>
                                    <input type="file" class="form-control-file" id="images" name="images">
                                </div>

                                <button type="submit" class="btn btn-primary btn-update">更新</button>
                            </form>
                        @else
                        <!-- 他人の場合 -->
                            @if (Auth::user()->isFollowing($user->id))
                                <button type="button" class="unfollow-button" data-user-id="{{ $user->id }}">フォロー解除</button>
                            @else
                                <button type="button" class="follow-button" data-user-id="{{ $user->id }}">フォローする</button>
                            @endif

                            <!--投稿 -->
                            @foreach($user->posts as $post)
                                <div class="card mb-4 shadow-sm">
                                    <img class="bd-placeholder-img card-img-top" src="{{ asset('storage/' . $post->user->images) }}">
                                    <div class="card-body">
                                        <p class="card-text">{{ $post->user->username }}</p>
                                        <p class="card-text">{{ $post->post }}</p>
                                        <p class="card-text">{{ $post->created_at }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
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
        $('.follow-button').click(function(event) {
            event.preventDefault();
            var userId = $(this).data('user-id');

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

            $.ajax({
                url: '/unfollow',
                method: 'POST',
                data: { id: userId },
                success: function() {
                    location.reload();
                }
            });
        });
    });
    </script>
@endsection
