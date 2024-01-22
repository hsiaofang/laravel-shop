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
            <a class="dropdown-item" href="{{ route('order') }}">我的訂單</a>
            <a class="dropdown-item" href="{{ route('favorite') }}">我的收藏</a>
            @endsection
            <div class="mt-4">
                @if(!empty($orders) && count($orders) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>訂單編號</th>
                            <th>用戶名稱</th>
                            <th>Email</th>
                            <!-- <th>購物車內容</th> -->
                            <th>已付款</th>
                            <th>創建時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->email }}</td>
                            <!-- <td>{{ $order->cart }}</td> -->
                            <td>{{ $order->paid ? '是' : '否' }}</td>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @else
                <p style="text-align: center;">目前沒有訂單</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection