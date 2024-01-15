@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">商品管理</h1>
    @section('dropdown-item')
        <a class="dropdown-item" href="{{ route('admin.product') }}">商品管理</a>
        <a class="dropdown-item" href="{{ route('admin.order') }}">訂單管理</a>
        <a class="dropdown-item" href="{{ route('admin.user') }}">用戶管理</a>
    @endsection
    <a class="btn btn-primary my-3" href="{{ route('admin.products.create') }}">新增商品</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>名稱</th>
                <th>描述</th>
                <th>價格</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editProduct({{ $product->id }})">修改</button>
                        <button class="btn btn-danger" onclick="deleteProduct({{ $product->id }})">刪除</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="editForm" class="mt-3" style="display: none;">
        <form id="productForm">
            @csrf 
            <label for="name">名稱：</label>
            <input type="text" id="name" name="name" class="form-control mb-2">
            <label for="description">描述：</label>
            <textarea id="description" name="description" class="form-control mb-2"></textarea>
            <label for="price">價格：</label>
            <input type="number" id="price" name="price" class="form-control mb-2">
            <button class="btn btn-success" onclick="submitEditedProduct()">儲存修改</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var productId;

    function editProduct(id) {
        productId = id;

        document.getElementById('editForm').style.display = 'block';

        $.get(`/admin/products/${id}/edit`, function(data) {
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('price').value = data.price;
        });
    }

    function submitEditedProduct() {
        var editedProduct = {
            _token: "{{ csrf_token() }}", 
            name: document.getElementById('name').value,
            description: document.getElementById('description').value,
            price: document.getElementById('price').value
        };

        $.ajax({
            type: 'PUT',
            url: `/admin/products/${productId}/update`,
            data: editedProduct,
            success: function(response) {
                console.log(response); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });

        document.getElementById('editForm').style.display = 'none';
    }

    function deleteProduct(productId) {
        $.ajax({
            type: 'DELETE',
            url: `/admin/products/${productId}/delete`, 
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response); 
                location.reload(); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });
    }
</script>
</script>
@endsection
</body>
</html>
