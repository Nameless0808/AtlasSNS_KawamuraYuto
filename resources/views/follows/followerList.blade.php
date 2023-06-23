@extends('layouts.login')

@section('content')

<div class="container">
    <div class="title-and-icons">
        <h1>Follower List</h1>
        <div class="follower-icons">
            @foreach($followers as $follower)
                <a href="{{ route('users.show', ['user' => $follower->id]) }}">
                    @if ($follower->images)
                        <img class="follower-image" src="{{ asset('storage/' . $follower->images) }}">
                    @else
                        <img class="follower-image" src="{{ asset('public/images/icon1.png') }}">
                    @endif
                </a>
            @endforeach
        </div>
    </div>
    <hr class="style-one"> <!-- 区切り -->
    <!-- フォロワーの投稿 -->
    <div class="full-width-container">
        @foreach($followers as $follower)
            <div class="follower-post">
                <a href="/user/{{ $follower->id }}">
                    @if ($follower->images)
                        <img class="follower-image" src="{{ asset('storage/' . $follower->images) }}">
                    @else
                        <img class="follower-image" src="{{ asset('public/images/icon1.png') }}">
                    @endif
                </a>
                <div class="follower-content">
                    <div class="user-info">
                        <p class="follower-username">{{ $follower->username }}</p>
                        @if($follower->latest_post)
                            <p class="follower-post-time">{{ $follower->latest_post->created_at }}</p>
                        @endif
                    </div>
                    @if($follower->latest_post)
                        <p class="follower-post-text">{{ $follower->latest_post->post }}</p>
                    @else
                        <p class="follower-post-text">まだ、投稿がありません</p>
                    @endif
                </div>
            </div>
            <hr>
        @endforeach
    </div>
</div>

@endsection
