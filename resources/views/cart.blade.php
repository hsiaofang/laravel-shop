<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>購物車</title>
</head>
<body>
    <h1>購物車</h1>

    <div class="cart-list">
        @if(count($cartItems) > 0)
            <ul>
                @foreach($cartItems as $cartItem)
                    <li>
                        <h2>{{ $cartItem->product->name }}</h2>
                        <p>價格：{{ $cartItem->product->price }}</p>
                        <p>數量：{{ $cartItem->quantity }}</p>

                        <form action="/remove-from-cart" method="POST">
                            @csrf
                            <input type="hidden" name="cart_item_id" value="{{ $cartItem->id }}">
                            <button type="submit">從購物車移除</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p>購物車中沒有商品。</p>
        @endif
    </div>
</body>
</html>
