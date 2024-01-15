@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">用戶管理</h1>
    @section('dropdown-item')
        <a class="dropdown-item" href="{{ route('admin.product') }}">商品管理</a>
        <a class="dropdown-item" href="{{ route('admin.order') }}">訂單管理</a>
        <a class="dropdown-item" href="{{ route('admin.user') }}">用戶管理</a>
    @endsection
    <table class="table table-bordered" id="userTable">
        <thead>
            <tr>
                <th>用戶ID</th>
                <th>角色</th>
                <th>用户名</th>
                <th>Email</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <button class="btn btn-primary" onclick="editUser({{ $user->id }})">修改</button>
                    <button class="btn btn-danger" onclick="deleteUser({{ $user->id }})">删除</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="editForm" class="mt-3" style="display: none;">
</div>

@endsection

@section('scripts')
<script>
    var userId;

    function editUser(id) {
        userId = id;

        document.getElementById('editForm').style.display = 'block';

        $.get(`/admin/users/${id}/edit`, function (data) {
        });
    }

    function deleteUser(userId) {
        $.ajax({
            type: 'DELETE',
            url: `/admin/users/${userId}/delete`,
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
@endsection
