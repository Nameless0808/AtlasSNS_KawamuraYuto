@extends('layouts.logout')

@section('content')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">

<div id="clear">
  <p>{{ $username }}さん</p>
  <p>ようこそ！AtlasSNSへ！</p>
  <p>ユーザー登録が完了しました。</p>
  <p>早速ログインをしてみましょう。</p>

  <div class="btn"><a href="/login">ログイン画面へ</a></div>
</div>

@endsection
