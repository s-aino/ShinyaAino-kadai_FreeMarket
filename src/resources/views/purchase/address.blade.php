@extends('layouts.app')
@section('title','配送先の入力')
@section('content')
<h1>配送先の入力</h1>

<p>商品ID: {{ $itemId ?? ($item->id ?? 'N/A') }}</p>

@if (session('message')) <p>{{ session('message') }}</p> @endif
@if ($errors->any())
<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
@endif

<form method="POST" action="{{ route('purchase.updateAddress', $itemId ?? ($item->id ?? 0)) }}">
    @csrf
    <div>
        <label>郵便番号（例: 123-4567）</label>
        <input name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}">
    </div>
    <div>
        <label>都道府県</label>
        <input name="prefecture" value="{{ old('prefecture', $address->prefecture ?? '') }}">
    </div>
    <div>
        <label>市区町村</label>
        <input name="city" value="{{ old('city', $address->city ?? '') }}">
    </div>
    <div>
        <label>番地</label>
        <input name="address_line1" value="{{ old('address_line1', $address->address_line1 ?? '') }}">
    </div>
    <div>
        <label>建物名（任意）</label>
        <input name="address_line2" value="{{ old('address_line2', $address->address_line2 ?? '') }}">
    </div>
    <div>
        <label>電話番号（任意）</label>
        <input name="phone" value="{{ old('phone', $address->phone ?? '') }}">
    </div>

    <button type="submit">住所を保存する</button>
</form>

<p><a href="{{ route('purchase.create', $itemId ?? ($item->id ?? 0)) }}">購入確認へ戻る</a></p>
@endsection