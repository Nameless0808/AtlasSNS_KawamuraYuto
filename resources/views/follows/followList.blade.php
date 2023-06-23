@extends('layouts.login')

@section('content')

    <div class="container">
    <div class="title-and-icons">
        <h1>Follow List</h1>
        <div class="following-icons">
            @foreach($followings as $following)
                <a href="{{ route('users.show', ['user' => $following->id]) }}">
                    @if ($following->images)
                        <img class="following-image" src="{{ asset('storage/' . $following->images) }}">
                    @else
                        <img class="following-image" src="{{ asset('public/images/icon1.png') }}">
                    @endif
                </a>
            @endforeach
        </div>
    </div>
        <hr class="style-one"> <!-- 区切り -->
        <!-- フォローしている人の投稿s -->
    <div class="full-width-container">
    @foreach($followings as $following)
        <div class="following-post">
            <a href="/user/{{ $following->id }}">
                @if ($following->images)
                    <img class="following-image" src="{{ asset('storage/' . $following->images) }}">
                @else
                    <img class="following-image" src="{{ asset('public/images/icon1.png') }}">
                @endif
            </a>
                <div class="following-content">
                  <div class="user-info">
                    <p class="following-username">{{ $following->username }}</p>
                    @if($following->latest_post)
                       <p class="following-post-time">{{ $following->latest_post->created_at }}</p>
                    @endif
                   </div>
                @if($following->latest_post)
                  <p class="following-post-text">{{ $following->latest_post->post }}</p>
                @else
                  <p class="following-post-text">まだ、投稿がありません</p>
                @endif
                </div>
        </div>
        <hr>
        @endforeach
    </div>
    </div>
@endsection
