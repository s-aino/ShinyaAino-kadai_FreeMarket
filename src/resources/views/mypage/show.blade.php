@extends('layouts.app')
@section('title','マイページ')
@section('content')
<h1>マイページ</h1>

<p>ようこそ、{{ auth()->user()->name ?? 'ゲスト' }} さん</p>

<ul>
    <li><a href="{{ route('mypage.purchases') }}">購入履歴</a></li>
    <li><a href="{{ route('mypage.sales') }}">出品一覧</a></li>
</ul>
@endsection