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
                            <h2 class="product-title">{{ $product->name }}</h2>
                            <p class="product-price">{{ $product->price }}</p>
                            <form action="{{ route('addToCart', ['id' => $product->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="add-to-cart-btn">加入購物車</button>
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
        // 監聽加入購物車按鈕點擊事件
        document.querySelectorAll('.add-to-cart-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                var productId = this.getAttribute('data-product-id');

                // 發送 Ajax 請求到後端的購物車 API
                fetch('/api/add-to-cart/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: 1 })
                })
                    .then(response => response.json())
                    .then(data => {
                        // 在這裡處理後端返回的數據，例如更新購物車數量或顯示成功消息
                        console.log(data);
                    })
                    .catch(error => {
                        // 處理錯誤
                        console.error('Error:', error);
                    });
            });
        });
    });
</script>
@endsection