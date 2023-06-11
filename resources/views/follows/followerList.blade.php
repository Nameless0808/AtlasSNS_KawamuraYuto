@extends('layouts.login')

@section('content')
<style>
.follower-image {
    width: 64px;  /* アイコンの幅を64pxに設定 */
    height: 64px; /* アイコンの高さを64pxに設定 */
    margin-right: 5px; /* 右マージンを5に設定 */
}
</style>
<div class="container">
    <h1>Follower List</h1>
    <hr> <!-- Horizontal line -->
    <div class="row">
        @foreach($followers as $follower)
            <div class="col-md-4">
                <!-- Follower Image -->
                <a href="/user/{{ $follower->id }}">
                    <img class="bd-placeholder-img card-img-top follower-image" src="{{ asset('storage/' . $follower->images) }}">
                </a>
            </div>
        @endforeach
    </div>
    <hr> <!-- Horizontal line -->
    <!-- Posts of followers -->
    <div class="row">
        @foreach($followers as $follower)
            @if($follower->latest_post)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <a href="/user/{{ $follower->id }}">
                            <img class="bd-placeholder-img card-img-top follower-image" src="{{ asset('storage/' . $follower->images) }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $follower->username }}</h5>
                            <p class="card-text">{{ $follower->latest_post->post }}</p>
                            <p class="card-text">{{ $follower->latest_post->created_at }}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
