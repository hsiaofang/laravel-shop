@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">統計數據</h1>
    @section('dropdown-item')
    <a class="dropdown-item" href="{{ route('admin.product') }}">商品管理</a>
    <a class="dropdown-item" href="{{ route('admin.order') }}">訂單管理</a>
    <a class="dropdown-item" href="{{ route('admin.user') }}">使用者管理</a>
    @endsection
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">總銷售額</h5>
                    <p class="card-text">NTD {{ $totalSales }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">總訪問量</h5>
                    <p class="card-text">{{ $totalVisits }} 次</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">總收藏量</h5>
                    <p class="card-text">{{ $totalFavorites }} 次</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">今日訂單</h5>
                    <p class="card-text">{{ $todayOrders }} 筆</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">本月訂單</h5>
                    <p class="card-text">{{ $monthlyOrders }} 筆</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
