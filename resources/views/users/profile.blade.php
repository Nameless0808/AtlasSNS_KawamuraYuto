@extends('layouts.login')

@section('content')

<div class="container user-profile">

    <!-- アイコン名前自己紹介 -->
    <div class="{{ (Auth::user()->id == $user->id) ? 'user-header' : 'other-user-header' }}">
        <div class="user-avatar">
            @if (Auth::user()->id == $user->id)
                <img src="{{ asset('storage/' . Auth::user()->images) }}" alt="User Image" class="user-image">
            @else
                <img src="{{ asset('storage/' . $user->images) }}" alt="User Image" class="user-image">
            @endif
    </div>

        <div class="user-details">

            @if (Auth::user()->id == $user->id)
                <!-- 自分のプロフィール -->
                <div class="edit-profile-form">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="username">user name</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                            @error('username')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mail">mail address</label>
                            <input type="mail" class="form-control" id="mail" name="mail" value="{{ $user->mail }}">
                            @error('mail')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">password confirm</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bio">bio</label>
                            <textarea class="form-control bio-textarea" id="bio" name="bio" rows="3">{{ $user->bio }}</textarea>
                            @error('bio')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="images">icon image</label>
                            <input type="file" class="form-control-file" id="images" name="images">
                        </div>

                        <button type="submit" class="btn btn-primary btn-update">更新</button>
                    </form>
                </div>
            @else
                <div class="user-labels">
                    <div class="user-name-label">ユーザー名</div>
                    <div class="user-bio-label">bio</div>
                </div>
                <div class="user-info user-header-info">
                    <div class="user-username">{{ $user->username }}</div>
                    <div class="user-bio">{{ $user->bio }}</div>
                </div>

                <div class="follow-button-container">
                    <!-- Follow/Unfollow buttons -->
                    @if (Auth::user()->isFollowing($user->id))
                        <button type="button" class="unfollow-button" data-user-id="{{ $user->id }}">フォロー解除</button>
                    @else
                        <button type="button" class="follow-button" data-user-id="{{ $user->id }}">フォローする</button>
                    @endif
                </div>

            @endif
        </div>
    </div>

    @if (Auth::user()->id != $user->id)
    <hr class="style-one"> <!-- 区切り -->
@endif


    <!-- User posts (only displayed if it's not the current user's profile) -->
    @if (Auth::user()->id != $user->id)
        <div class="full-width-container">
            @foreach($user->posts as $post)
                <div class="following-post">
                    <img class="following-image" src="{{ asset('storage/' . $post->user->images) }}">
                    <div class="following-content">
                        <div class="user-info">
                            <p class="following-username">{{ $post->user->username }}</p>
                            <p class="following-post-time">{{ $post->created_at }}</p>
                        </div>
                        <p class="following-post-text">{{ $post->post }}</p>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    @endif
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
                 },
                 error: function() {
                      alert("フォローに失敗しました。");
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
