@extends('layouts.logout')

@section('content')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
{!! Form::open(['url' => '/login']) !!}


<p class="welcome-text">AtlasSNSへようこそ</p>

<div class="input-field">
  {{ Form::label('e-mail') }}
  {{ Form::text('mail',null,['class' => 'input']) }}
</div>
<div class="input-field">
  {{ Form::label('password') }}
  {{ Form::password('password',['class' => 'input']) }}
</div>

<div class="button-container">
  {{ Form::submit('ログイン', ['class' => 'login-button']) }}
</div>

<p><a href="/register">新規ユーザーの方はこちら</a></p>

{!! Form::close() !!}


@endsection
