<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa hồ sơ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <style>
/* ========================= */
/* CONTAINER STYLES           */
/* ========================= */

.custom-container {
    max-width: 1280px;
    margin: 40px auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ========================= */
/* TITLE STYLES              */
/* ========================= */

.title {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 24px;
    color: #1f2937;
}

/* ========================= */
/* ALERT WARNING STYLES      */
/* ========================= */

.alert-warning {
    background-color: #fff8e1;
    color: #b45309;
    padding: 16px;
    border-radius: 8px;
    text-align: center;
    font-weight: 500;
}

/* ========================= */
/* TABLE STYLES              */
/* ========================= */

.table-wrapper {
    overflow-x: auto;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden;
}

.custom-table th, .custom-table td {
    border: 1px solid #e5e7eb;
    padding: 14px 12px;
    text-align: center;
    color: #374151;
    vertical-align: middle;
}

.custom-table thead {
    background-color: #f3f4f6;
    font-weight: 600;
}

/* ========================= */
/* IMAGE STYLES             */
/* ========================= */

.product-image {
    width: 60px;
    height: auto;
    border-radius: 6px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
}

/* ========================= */
/* ACTION BUTTONS STYLES     */
/* ========================= */

.actions {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
}

.btn {
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.btn.info {
    background-color: #3b82f6;
    color: #fff;
}

.btn.warning {
    background-color: #facc15;
    color: #1f2937;
}

.btn.danger {
    background-color: #ef4444;
    color: #fff;
    border: none;
}

.btn:hover {
    opacity: 0.9;
}

/* ========================= */
/* FORM STYLES              */
/* ========================= */

.inline-form {
    display: inline;
}


    </style>
    <div class="custom-container">
        <h1 class="title">Chỉnh sửa hồ sơ</h1>

        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa tài khoản</button>
        </form>
        
    </div>
</body>
</html>
