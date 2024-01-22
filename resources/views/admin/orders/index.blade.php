@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">訂單管理</h1>
    @section('dropdown-item')
    <a class="dropdown-item" href="{{ route('admin.product') }}">商品管理</a>
    <a class="dropdown-item" href="{{ route('admin.order') }}">訂單管理</a>
    <a class="dropdown-item" href="{{ route('admin.user') }}">使用者管理</a>
    @endsection
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
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->user_id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>
                    @if(isset($order->parsedCart))
                    <ul>
                        @foreach($cartData as $item)
                        <li>{{ $item->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td>{{ $order->paid }}</td>
                <td>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">沒有訂單</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div id="editForm" class="mt-3" style="display: none;">
    </div>
</div>

@endsection

@section('scripts')
<script>
</script>
@endsection
