@extends('layouts.app')

@section('content')
    <div id="main-content">
        <h1>Products</h1>
        <ul>
            @foreach($products as $product)
                <li>
                    <a href="{{ route('product.details', $product->id) }}" class="ajax-link">
                        {{ $product->name }} - ${{ $product->price }}
                    </a>
                </li>
            @endforeach
        </ul>
        {{ $products->links() }}
    </div>
@endsection
