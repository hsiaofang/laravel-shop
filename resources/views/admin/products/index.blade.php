@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">商品管理</h1>
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @section('dropdown-item')
    <a class="dropdown-item" href="{{ route('admin.product') }}">商品管理</a>
    <a class="dropdown-item" href="{{ route('admin.order') }}">訂單管理</a>
    <a class="dropdown-item" href="{{ route('admin.user') }}">用戶管理</a>
    @endsection
    <a class="btn btn-primary my-3" href="{{ route('admin.products.create') }}">新增商品</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>圖片</th>
                <th>名稱</th>
                <th>描述</th>
                <th>價格</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="max-width: 100px;"></td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>
                    <button class="btn btn-primary" onclick="editProduct({{ $product->id }})">修改</button>

                    <form action="{{ route('admin.products.delete', ['id' => $product->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">刪除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="editForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">編輯商品</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="productFormModal">
                        @csrf
                        <label for="name">名稱：</label>
                        <input type="text" id="edit-name" name="name" class="form-control mb-2">
                        <label for="description">描述：</label>
                        <textarea id="edit-description" name="description" class="form-control mb-2"></textarea>
                        <label for="price">價格：</label>
                        <input type="number" id="edit-price" name="price" class="form-control mb-2">
                        <button type="button" class="btn btn-success" onclick="submitEditedProduct()">儲存修改</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent

    <script>
        $(document).ready(function() {
            var productId;

            function editProduct(id) {
                productId = id;

                // 使用 jQuery 的 $ 函數
                $('#editForm').modal('show');

                $.get(`/admin/products/${id}/edit`, function (data) {
                    $('#edit-name').val(data.name);
                    $('#edit-description').val(data.description);
                    $('#edit-price').val(data.price);
                });
            }

            function submitEditedProduct() {
                var editedProduct = {
                    _token: "{{ csrf_token() }}",
                    name: $('#edit-name').val(),
                    description: $('#edit-description').val(),
                    price: $('#edit-price').val()
                };

                $.ajax({
                    type: 'PUT',
                    url: `/admin/products/${productId}/update`,
                    data: editedProduct,
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

                $('#editForm').modal('hide');
            }
        });
    </script>
@endsection

