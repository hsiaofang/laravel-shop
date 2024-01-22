@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="height: 56px;"></div>
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @section('dropdown-item')
            <a class="dropdown-item" href="{{ route('cart') }}">購物車</a>
            <a class="dropdown-item" href="{{ route('cart') }}">我的訂單</a>
            <a class="dropdown-item" href="{{ route('favorite') }}">我的收藏</a>
            @endsection

            <div class="mt-4">
                <h2>我的收藏</h2>
                @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row">
                    @forelse($favorites as $favorite)
                    <div class="col-md-3 mb-4">
                        <div class="product-card">
                            <button class="btn btn-danger" onclick="toggleFavorite(this, {{ $favorite['id'] }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-heart-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                                </svg> <img src="{{ asset($favorite['image']) }}" alt="{{ $favorite['name'] }}"
                                    class="img-fluid">
                                <h2 class="product-title">{{ $favorite['name'] }}</h2>
                                <p class="product-price">{{ $favorite['price'] }}</p>
                            </button>
                        </div>
                    </div>
                    @empty
                    <p>沒有收藏的商品</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFavorite(button, productId) {
        button.classList.toggle('btn-danger');
        button.classList.toggle('btn-outline-danger');

        if (button.classList.contains('btn-danger')) {
            console.log('收藏商品');
            addToFavorites(productId);
        } else {
            console.log('取消收藏');
            removeFromFavorites(productId);
        }
    }

    function addToFavorites(productId) {
        fetch('/addTofavorite/' + productId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
            .then(response => response.json())
            .then(data => {
                console.log('收藏商品:', data);
            })
            .catch(error => console.error('錯誤：', error));
    }

    function removeFromFavorites(productId) {
        fetch('/removeFavorite/' + productId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
            .then(response => response.json())
            .then(data => {
                console.log('取消收藏:', data);
                if (data.success) {
                    // 商品取消收藏成功，移除相應的商品卡片
                    const productCard = document.querySelector(`[data-product-id="${productId}"]`);
                    if (productCard) {
                        productCard.remove();
                    }
                }
            })
            .catch(error => console.error('錯誤：', error));
    }


</script>

@endsection