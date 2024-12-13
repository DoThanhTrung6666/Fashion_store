@extends('layout.admin')
<style>
    .filter-container {
    display: flex;
    align-items: center; /* Căn giữa theo chiều dọc */
    gap: 15px; /* Khoảng cách giữa các phần tử */
    margin-bottom: 20px; /* Khoảng cách bên dưới */
    margin-left: 300px
}

.input-group {
    display: flex;
    flex-direction: column; /* Xếp nhãn và input theo chiều dọc */
}

.input-group label {
    margin-bottom: 5px; /* Khoảng cách giữa nhãn và input */
    font-size: 14px;
    font-weight: bold;
}

.filter-container input {
    height: 36px; /* Đảm bảo chiều cao đồng nhất */
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.filter-container button {
    height: 36px; /* Chiều cao đồng nhất với input */
    padding: 0 20px; /* Khoảng cách ngang */
    font-size: 14px;
    border-radius: 4px;
    margin-top: 0px; /* Đẩy nút xuống giữa dòng */
    
}

.card {
    height: 150px; /* Tạo chiều cao bằng chiều rộng để thành hình vuông */
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 15px; /* Khoảng cách giữa các thẻ */
}

.card h5 {
    font-size: 16px; /* Điều chỉnh kích thước tiêu đề */
    margin-bottom: 10px;
}

.card .card-text {
    font-size: 18px; /* Kích thước chữ trong thẻ */
    font-weight: bold;
}

.row.mb-4 {
    margin-left: -15px; /* Đảm bảo khoảng cách lề trong grid */
    margin-right: -15px;
}

.col-md-3 {
    flex: 0 0 calc(25% - 30px); /* Đảm bảo kích thước 25% và trừ khoảng cách */
    max-width: calc(25% - 30px); /* Cân chỉnh với flexbox */
    padding: 0;
}


</style>
@section('content')
<div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-12">
                <div class="box box-primary">

                    <h1 class="mt-4">Thống kê</h1>

                    <!-- Form chọn khoảng thời gian -->
                    <form method="GET" action="{{ route('admin.statistics.index') }}" class="mb-4">
                        <div class="filter-container ">
                            <div class="input-group">
                                <label for="start_date">Ngày bắt đầu: </label>
                                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}">
                            </div>
                            <div class="input-group">
                                <label for="end_date">Ngày kết thúc:</label>
                                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Lọc</button>
                        </div>
                    </form>
                    
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-money-bill-wave"></i> Doanh Thu Hôm Nay
                                    </h5>
                                    <p class="card-text fs-4"><strong>{{ number_format($todayRevenue, 0, ',', '.') }} đ</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-box"></i> Đơn Hàng Trong Tuần
                                    </h5>
                                    <p class="card-text fs-4"><strong>{{ $weeklyOrders }}</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-users"></i> Khách Hàng
                                    </h5>
                                    <p class="card-text fs-4"><strong>{{ $totalCustomers }}</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-calendar-day"></i> Doanh Thu Tháng Này
                                    </h5>
                                    <p class="card-text fs-4"><strong>{{ $formattedCurrentMonthRevenue }}</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-clipboard-list"></i> Đơn Hàng
                                    </h5>
                                    <p class="card-text fs-4"><strong>{{ $totalOrders }}</strong></p>
                                    <a class="text-white " href="{{route('admin.orders.index')}}">Xem Tất Cả</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-cogs"></i> Sản Phẩm
                                    </h5>
                                    <p class="card-text fs-4"><strong>{{ $totalProducts }}</strong></p>
                                    <a class="text-white " href="{{route('admin.products.index')}}">Xem Tất Cả</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-check-circle"></i> Sản Phẩm Đã Bán
                                    </h5>
                                    <p class="card-text fs-4"><strong>{{ $totalProductsSold }}</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-secondary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-tags"></i> Số Sản Phẩm Sale
                                    </h5>
                                    <p class="card-text fs-4"><strong>{{ $totalProductsOnSale }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h3 class="text-center">Doanh Thu Theo Ngày</h3>
                            <div id="revenue_chart" style="width: 100%; height: 400px;"></div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h3 class="text-center">Người dùng đặt hàng nhiều nhất</h3>
                            <div id="top_users_chart" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>
                    

                    

                    <!-- Top sản phẩm -->
                    <div class="row">
                        <div class="card-body">
                            <h3 class="text-center">Sản phẩm bán chạy nhất</h3>
                            <div id="top_products_chart" style="height: 400px;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
    </section>
</div>

<!-- Google Charts Scripts -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        drawRevenueChart();
        drawTopUsersChart();
        drawTopProductsChart();
    }

    function drawRevenueChart() {
        var data = google.visualization.arrayToDataTable([
            ['Ngày', 'Doanh thu'],
            @foreach ($revenueDates as $index => $date)
                ['{{ $date }}', {{ $revenueValues[$index] }}],
            @endforeach
        ]);

        var options = {
            
            curveType: 'function',
            legend: { position: 'bottom' },
            colors: ['#FF3300']
        };

        var chart = new google.visualization.LineChart(document.getElementById('revenue_chart'));
        chart.draw(data, options);
    }

    function drawTopUsersChart() {
// Dữ liệu từ backend
var data = google.visualization.arrayToDataTable([
    ['Tên người dùng', 'Số lượng đơn hàng'],
    @foreach ($topUsers as $order)
        ['{{ $order->user->name }}', {{ $order->order_count }}],
    @endforeach
]);

// Tạo mảng màu với mỗi tên người dùng một màu
var colors = [];
@foreach ($topUsers as $order)
    colors.push(getRandomColor());
@endforeach

var options = {
    pieHole: 0.4, // Biểu đồ dạng donut
    colors: colors, // Gắn mảng màu vào biểu đồ
    legend: { position: 'right' },
};

var chart = new google.visualization.PieChart(document.getElementById('top_users_chart'));
chart.draw(data, options);

}

// Hàm tạo màu ngẫu nhiên
function getRandomColor() {
const letters = '0123456789ABCDEF';
let color = '#';
for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
}
return color;
}


    function drawTopProductsChart() {
        var data = google.visualization.arrayToDataTable([
            ['Tên sản phẩm', 'Số lượng đã bán'],
            @foreach ($topProducts as $order)
                ['{{ $order->product_name }}', {{ $order->total_sold }}],
                
            @endforeach
            
        ]);

        var options = {
        
            bar: { groupWidth: '75%' },
            legend: { position: 'none' },
            colors: ['#00FFFF']
        };

        var chart = new google.visualization.BarChart(document.getElementById('top_products_chart'));
        chart.draw(data, options);
    }
</script>
@endsection