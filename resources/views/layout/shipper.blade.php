<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao Diện Shipper</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- FontAwesome Icons -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #333;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px;
            margin: 0 10px;
        }

        .navbar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 30px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 20px;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .card i {
            font-size: 40px;
            color: #333;
            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }

        .card p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer p {
            margin: 0;
        }

        .section-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
        }

        .stats-card {
            background-color: #ececec;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 10px;
            width: 80%;
            max-width: 300px;
            display: inline-block;
            text-align: center;
        }

        .stats-card h4 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .stats-card p {
            font-size: 18px;
            margin-bottom: 0;
        }

        .icon-container {
            display: flex;
            justify-content: space-evenly;
            margin-top: 40px;
            width: 100%;
        }

        .icon-box {
            background-color: #ddd;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 100px;
            cursor: pointer;
        }

        .icon-box:hover {
            background-color: #bbb;
        }

        .icon-box i {
            font-size: 30px;
            color: #333;
        }

        .icon-box p {
            font-size: 14px;
            margin-top: 10px;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="navbar">
        @if(Auth::guard('shipper')->user())
            <div class="logo">Xin chào - {{ Auth::guard('shipper')->user()->name }}</div>
        @endif
        <div>
            <a href="{{route('shipper.orders.index2')}}">Trang Chủ</a>
            <a href="{{route('shipper.orders.index')}}">Đơn Hàng</a>
            <a href="#">Thông Báo</a>
            <a href="#">Cài Đặt</a>
        </div>
    </div>

    @yield('content')

    <div class="footer">
        <p>&copy; 2024 Giao Diện Shipper | Tất cả quyền được bảo vệ</p>
    </div>

</body>

</html>
