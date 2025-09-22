@extends('layouts.app')
@section('title','購入確認')
@section('content')
<h1>購入確認</h1>

{{-- 開発用の最小表示（本番は商品名や価格を表示） --}}
<p>商品ID: {{ $itemId ?? ($item->id ?? 'N/A') }}</p>

@if ($errors->any())
  <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
@endif

<form method="POST" action="{{ route('purchase.store', $itemId ?? ($item->id ?? 0)) }}">
  @csrf
  <button type="submit">この内容で購入する</button>
</form>

<p><a href="{{ url('/') }}">戻る</a></p>
@endsection
