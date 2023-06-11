@extends('layouts.login')

@section('content')
<style>
.following-image {
    width: 64px;  /* アイコンの幅を64pxに設定 */
    height: 64px; /* アイコンの高さを64pxに設定 */
    margin-right: 5px; /* 右マージンを5に設定 */
}
</style>
    <div class="container">
        <h1>Follow List</h1>
        <hr> <!-- 区切り -->
        <div class="d-flex flex-row align-items-start">
            @foreach($followings as $following)
                <!-- 区切り -->
                <a href="{{ route('users.show', ['user' => $following->id]) }}">
                       <img class="bd-placeholder-img following-image" src="{{ asset('storage/' . $following->images) }}">
                </a>
            @endforeach
        </div>
        <hr> <!-- 区切り -->
        <!-- フォローしている人の投稿s -->
        <div class="d-flex flex-column align-items-start">
            @foreach($followings as $following)
                <div class="card mb-4 shadow-sm">
                    <a href="/user/{{ $following->id }}">
                        <img class="bd-placeholder-img card-img-top following-image" src="{{ asset('storage/' . $following->images) }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $following->username }}</h5>
                        @if($following->latest_post)
                            <p class="card-text">{{ $following->latest_post->post }}</p>
                            <p class="card-text">{{ $following->latest_post->created_at }}</p>
                        @else
                            <p class="card-text">まだ、投稿がありません</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
