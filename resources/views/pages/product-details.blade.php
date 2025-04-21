@extends('layouts.app')

@section('content')
    <div id="main-content">
        <h1>{{ $product->name }}</h1>
        <p>Price: ${{ $product->price }}</p>
        <a href="{{ route('products') }}" class="ajax-link">Back to Products</a>
    </div>
@endsection
