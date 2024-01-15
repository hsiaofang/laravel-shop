@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="height: 56px;"></div>

            <div class="mt-4">
                @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                @section('dropdown-item')
                <a class="dropdown-item" href="{{ route('cart') }}">我的訂單</a>
                @endsection
                <div class="row">
                    @if(isset($products) && count($products) > 0)
                    @foreach($products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="product-card">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            <h2 class="product-title">{{ $product->name }}</h2>
                            <p class="product-price">{{ $product->price }}</p>
                            <form action="{{ route('addToCart', ['id' => $product->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="add-to-cart-btn" data-product-id="{{ $product->id }}">加入購物車</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p>沒有商品</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-to-cart-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var productId = this.getAttribute('data-product-id');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch('/api/add-to-cart/' + productId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ quantity: 1 })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});

</script>
@endsection
