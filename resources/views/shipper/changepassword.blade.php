@extends('layout.shipper')
@section('content')
<div class="login-container">
    <div class="login-form">
        <h2>Đổi mật khẩu</h2>

        <form action="{{ route('changePassword') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="username">Mật khẩu hiện tại</label>
                <input type="text" id="username" name="current_password"  placeholder="Nhập email" class="input-field">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu mới</label>
                <input type="password" id="password" name="new_password"  placeholder="Nhập mật khẩu" class="input-field">
            </div>
            <div class="form-group">
                <label for="password">Xác nhận mật khẩu mới</label>
                <input type="password" id="password" name="new_password_confirmation"  placeholder="Nhập mật khẩu" class="input-field">
            </div>

            <div class="form-group">
                <button type="submit" class="btn-login">Đổi</button>
            </div>
            @if (session('success'))
            <div style="color: green">{{ session('success') }}</div>
        @endif
    
        @if ($errors->any())
            <div style="color: red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </form>

        <div class="login-footer">
            <p>Quên mật khẩu? <a href="#">Khôi phục mật khẩu</a></p>
        </div>
    </div>
</div>
@endsection
<style>
    /* Toàn bộ giao diện */


.login-container {
    width: 100%;
    max-width: 400px;
    margin: auto;
    background-color: white;
    padding: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-top: 50px;
}

.login-form {
    display: flex;
    flex-direction: column;
}

h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
    display: block;
}

.input-field {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
    background-color: #fafafa;
}

.input-field:focus {
    border-color: #4CAF50;
    outline: none;
}

.btn-login {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
}

.btn-login:hover {
    background-color: #45a049;
}

.login-footer {
    text-align: center;
    margin-top: 20px;
}

.login-footer p {
    font-size: 14px;
}

.login-footer a {
    color: #4CAF50;
    text-decoration: none;
}

.login-footer a:hover {
    text-decoration: underline;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .login-container {
        width: 90%;
        padding: 20px;
    }

    h2 {
        font-size: 20px;
    }

    .input-field {
        font-size: 14px;
        padding: 10px;
    }

    .btn-login {
        font-size: 14px;
        padding: 10px;
    }
}

</style>
