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

                    <h2>訂單確認</h2>

                    {{-- 表單 --}}
                    <form action="{{ route('payment') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">姓名：</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email：</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="shipping_address">寄送地址：</label>
                            <textarea name="shipping_address" class="form-control" rows="3" required></textarea>
                        </div>

                        {{-- 顯示訂單內容 --}}
                        @if($order && $products && is_countable($products) && count($products) > 0)
                        <p><strong>訂單編號：</strong>{{ $order->order_number }}</p>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">商品名稱</th>
                                        <th scope="col">價格</th>
                                        <th scope="col">數量</th>
                                        <th scope="col">小計</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->total_price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <p><strong>總金額：</strong>{{ $order->total_price }}</p>

                            <input name="order_number" value="{{ $order->order_number }}">
                            <input name="total_price" value="{{ $order->total_price }}">
                        @else
                            <p>訂單不存在或內容有誤。</p>
                        @endif
                        
                        <button type="submit" class="btn btn-primary">提交訂單</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
