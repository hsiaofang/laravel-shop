@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">訂單管理</h1>
    @section('dropdown-item')
    <a class="dropdown-item" href="{{ route('admin.product') }}">商品管理</a>
    <a class="dropdown-item" href="{{ route('admin.order') }}">訂單管理</a>
    <a class="dropdown-item" href="{{ route('admin.user') }}">使用者管理</a>
    @endsection
    <a class="btn btn-primary my-3" href="{{ route('admin.products.create') }}">新增商品</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Cart</th>
                <th>Paid</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            {{-- 使用 @forelse 進行迴圈，避免當沒有訂單時產生錯誤 --}}
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->user_id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>
                    @if(isset($order->parsedCart))
                    <ul>
                        {{-- 使用 @foreach 遍歷 parsedCart 中的 items --}}
                        @foreach($cartData as $item)
                        <li>{{ $item->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td>{{ $order->paid }}</td>
                <td>
                    {{-- 這裡加上您的操作按鈕 --}}
                </td>
            </tr>
            @empty
            {{-- 如果沒有訂單，顯示一個提示 --}}
            <tr>
                <td colspan="6">沒有訂單</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div id="editForm" class="mt-3" style="display: none;">
        {{-- 這裡加上您的修改表單 --}}
    </div>
</div>

@endsection

@section('scripts')
<script>
    // 在這裡添加 JavaScript 代碼
</script>
@endsection
