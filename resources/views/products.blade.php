<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>商品清單</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>商品清單</h1>

    <div class="text-right mt-3">
        <a href="#" class="btn btn-link text-dark">
            <img src="link_to_your_cart_image" alt="Cart Icon" style="width: 30px;">
        </a>
    </div>

    <div class="products-list">
        @if(count($products) > 0)
            <ul>
                @foreach($products as $product)
                    <li>
                        <h2>{{ $product->name }}</h2>
                        <p>{{ $product->description }}</p>
                        <p>價格：{{ $product->price }}</p>
                        <p>庫存：{{ $product->stock }}</p>

                        <button type="button" class="addToCartBtn" data-product-id="{{ $product->id }}">加入購物車</button>
                    </li>
                @endforeach
            </ul>
        @else
            <p>目前沒有任何商品。</p>
        @endif
    </div>

    <script>
        // 從 localStorage 中獲取用戶 ID
        const userId = localStorage.getItem('userId');

        // 監聽加入購物車按鈕的點擊事件
        const addToCartButtons = document.querySelectorAll('.addToCartBtn');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                const productId = button.getAttribute('data-product-id');

                // 使用 Fetch API 發送 POST 請求
                fetch('/addtocart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        user_id: userId,
                    }),
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then(data => {
                    console.log(data.message); // 在控制台中顯示回應訊息
                    // 在這裡處理回應，例如更新購物車數量或提醒用戶商品已成功加入購物車
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
            });
        });
    </script>
</body>
</html>
