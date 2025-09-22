@extends('layouts.app')
@section('title','商品出品')
@section('content')
<h1>商品出品</h1>

@if (session('message')) <p>{{ session('message') }}</p> @endif
@if ($errors->any())
<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
@endif

<form method="POST" action="{{ route('items.store') }}">
    @csrf
    <div>
        <label>タイトル</label>
        <input type="text" name="title" value="{{ old('title') }}">
    </div>
    <div>
        <label>説明（任意）</label>
        <textarea name="description">{{ old('description') }}</textarea>
    </div>
    <div>
        <label>価格（円）</label>
        <input type="number" name="price" value="{{ old('price') }}" min="1">
    </div>
    <div>
        <label>カテゴリID（任意）</label>
        <input type="number" name="category_id" value="{{ old('category_id') }}">
    </div>
    <div>
        <label>画像パス（任意）</label>
        <input type="text" name="image_path" value="{{ old('image_path') }}">
    </div>
    <button type="submit">出品する</button>
</form>
@endsection