@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="height: 56px;"></div>
            <div style="height: 56px;"></div>
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @section('dropdown-item')
            <a class="dropdown-item" href="{{ route('cart') }}">購物車</a>
            <a class="dropdown-item" href="{{ route('order') }}">我的訂單</a>
            <a class="dropdown-item" href="{{ route('favorite') }}">我的收藏</a>
            @endsection
            <div class="mt-4">
                @if(!empty($products) && count($products) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>商品</th>
                            <th>價格</th>
                            <th>數量</th>
                            <th>總價</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product['item']['name'] }}</td>
                            <td>{{ $product['item']['price'] }}</td>
                            <td>{{ $product['qty'] }}</td>
                            <td>{{ $product['price'] }}</td>
                            <td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <p style="text-align: center;">總金額: ${{ $totalPrice }}</p>
                <p style="text-align: center;">總數量: {{ $totalQty }}</p>
                <div class="d-flex justify-content-between">
                    <form action="{{ route('shopping') }}" method="get">
                        <button type="submit">繼續購物</button>
                    </form>
                    <form action="{{ route('new') }}" method="get">
                        <button type="submit">前往結帳</button>
                </div>

                @else
                <p style="text-align: center;">購物車為空</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection