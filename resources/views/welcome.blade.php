<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOME</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .carousel-inner img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .login-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body class="antialiased">
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light">
        @if (Route::has('login'))
        <div class="login-buttons">
            @auth
            <a href="{{ url('/home') }}" class="btn btn-outline-primary">首頁</a>
            @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary">登入</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-outline-primary ms-2">註冊</a>
            @endif
            <a href="{{ route('login.provider', ['provider' => 'google']) }}" class="btn btn-primary ms-2">使用 Google
                登入</a>
            @endauth
        </div>
        @endif

        <div class="max-w-7xl mx-auto p-4">
            <div class="max-w-7xl mx-auto p-4">
                <div class="text-center">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/yours.png') }}" class="d-block w-100" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/yours1.png') }}" class="d-block w-100" alt="Slide 2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/yours2.jpeg') }}" class="d-block w-100" alt="Slide 2">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

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
</body>

</html>