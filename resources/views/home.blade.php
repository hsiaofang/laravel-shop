@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <!-- 顯示商品資訊 -->
                    <div class="mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                            @if(isset($products) && count($products) > 0)
                                @foreach($products as $product)
                                    <div class="product-card">
                                        <h2 class="product-title">{{ $product->name }}</h2>
                                        <p class="product-price">{{ $product->price }}</p>
                                        <a href="#" class="add-to-cart-btn">加入購物車</a>
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
    </div>
</div>
@endsection
