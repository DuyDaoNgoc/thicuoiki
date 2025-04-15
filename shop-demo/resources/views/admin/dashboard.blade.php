@extends('layouts.app')
<style>
    /* Reset margin và padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Cài đặt font chung */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    line-height: 1.6;
}

/* Định dạng phần header */
h1 {
    text-align: center;
    font-size: 2.5rem;
    margin-top: 20px;
    color: #444;
}

/* Menu admin */
.admin-menu {
    background-color: #fff;
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    max-width: 800px;
}

.admin-menu h2 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 5px;
    margin-bottom: 20px;
}

.admin-menu ul {
    list-style: none;
    padding-left: 0;
}

.admin-menu ul li {
    margin-bottom: 12px;
}

.admin-menu ul li a {
    display: block;
    padding: 12px;
    background-color: #3498db;
    color: white;
    font-size: 1rem;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.admin-menu ul li a:hover {
    background-color: #2980b9;
}

/* Responsive: Mobile */
@media (max-width: 768px) {
    .admin-menu {
        width: 90%;
        padding: 15px;
    }

    .admin-menu h2 {
        font-size: 1.5rem;
    }

    .admin-menu ul li a {
        font-size: 0.9rem;
        padding: 10px;
    }
}

</style>
@section('content')
    

    <div class="admin-menu">
        <!-- Quản lý sản phẩm -->
        <h2>Quản lý Sản phẩm</h2>
        <ul>
            <li>
                <!-- Sử dụng route cố định cho quản lý Áo -->
                <a href="{{ route('admin.products.manage.ao') }}">
                    Quản lý Áo
                </a>
            </li>
            <li>
                <!-- Sử dụng route cố định cho quản lý Quần -->
                <a href="{{ route('admin.products.manage.quan') }}">
                    Quản lý Quần
                </a>
            </li>
        </ul>

        <!-- Quản lý người dùng -->
        <h2>Quản lý Người dùng</h2>
        <ul>
            <li>
                <a href="{{ route('admin.users.index') }}">
                    Quản lý người dùng
                </a>
            </li>
        </ul>
    </div>
@endsection
