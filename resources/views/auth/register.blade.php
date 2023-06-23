@extends('layouts.logout')

@section('content')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
{!! Form::open(['url' => '/register']) !!}


  <h2 class="welcome-text">新規ユーザー登録</h2>

  <div class="input-field">
    {{ Form::label('ユーザー名') }}
    {{ Form::text('username',null,['class' => 'input']) }}
  </div>

  <div class="input-field">
    {{ Form::label('メールアドレス') }}
    {{ Form::text('mail',null,['class' => 'input']) }}
  </div>

  <div class="input-field">
    {{ Form::label('パスワード') }}
    {{ Form::password('password',['class' => 'input']) }}
  </div>

  <div class="input-field">
    {{ Form::label('パスワード確認') }}
    {{ Form::password('password_confirmation',['class' => 'input']) }}
  </div>

  <div class="button-container">
    {{ Form::submit('登録', ['class' => 'login-button']) }}
  </div>

  <p><a href="/login">ログイン画面へ戻る</a></p>
</div>
{!! Form::close() !!}

@endsection
