@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">新增商品</h1>
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">名稱：</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">描述：</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="price">價格：</label>
        <input type="number" id="price" name="price" required><br><br>

        <label for="quantity">數量：</label>
        <input type="number" id="quantity" name="quantity" required><br><br>


        <label for="image">圖片：</label>
        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" required><br><br>
        <img id="preview-image" src="#" alt="預覽圖片" style="display: none;">

        <input type="submit" value="新增商品">
    </form>
</div>
@endsection