@extends('layouts.app')

@section('title', $address && $address->exists ? '住所編集' : '住所登録')

@section('content')
<h1>{{ $address && $address->exists ? '住所編集' : '住所登録' }}</h1>

@if (session('message')) <p>{{ session('message') }}</p> @endif

@if ($errors->any())
  <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
@endif

<form method="post" action="{{ $address && $address->exists ? route('address.update') : route('address.store') }}">
  @csrf
  @if($address && $address->exists) @method('PUT') @endif

  <div>
    <label>郵便番号（例: 123-4567）</label>
    <input name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" required>
    @error('postal_code') <p>{{ $message }}</p> @enderror
  </div>
  <div>
    <label>都道府県</label>
    <input name="prefecture" value="{{ old('prefecture', $address->prefecture ?? '') }}" required>
    @error('prefecture') <p>{{ $message }}</p> @enderror
  </div>
  <div>
    <label>市区町村</label>
    <input name="city" value="{{ old('city', $address->city ?? '') }}" required>
    @error('city') <p>{{ $message }}</p> @enderror
  </div>
  <div>
    <label>番地</label>
    <input name="address_line1" value="{{ old('address_line1', $address->address_line1 ?? '') }}" required>
    @error('address_line1') <p>{{ $message }}</p> @enderror
  </div>
  <div>
    <label>建物名（任意）</label>
    <input name="address_line2" value="{{ old('address_line2', $address->address_line2 ?? '') }}">
  </div>
  <div>
    <label>電話番号（任意）</label>
    <input name="phone" value="{{ old('phone', $address->phone ?? '') }}">
  </div>

  <button type="submit">{{ $address && $address->exists ? '更新する' : '登録する' }}</button>
</form>
@endsection
