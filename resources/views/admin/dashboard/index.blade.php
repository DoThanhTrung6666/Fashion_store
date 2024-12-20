@extends('layout.admin')
<style>
    .filter-container {
        display: flex;
        align-items: center;
        /* Căn giữa theo chiều dọc */
        gap: 15px;
        /* Khoảng cách giữa các phần tử */
        margin-bottom: 20px;
        /* Khoảng cách bên dưới */
        margin-left: 300px
    }

    .input-group {
        display: flex;
        flex-direction: column;
        /* Xếp nhãn và input theo chiều dọc */
    }

    .input-group label {
        margin-bottom: 5px;
        /* Khoảng cách giữa nhãn và input */
        font-size: 14px;
        font-weight: bold;
    }

    .filter-container input {
        height: 36px;
        /* Đảm bảo chiều cao đồng nhất */
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .filter-container button {
        height: 36px;
        /* Chiều cao đồng nhất với input */
        padding: 0 20px;
        /* Khoảng cách ngang */
        font-size: 14px;
        border-radius: 4px;


       margin-top: 0px;
        /* Đẩy nút xuống giữa dòng */

    }

    .card {
        height: 150px;
        /* Tạo chiều cao bằng chiều rộng để thành hình vuông */
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 15px;
        /* Khoảng cách giữa các thẻ */
    }

    .card h5 {
        font-size: 16px;
        /* Điều chỉnh kích thước tiêu đề */
        margin-bottom: 10px;
    }

    .card .card-text {
        font-size: 18px;
        /* Kích thước chữ trong thẻ */
        font-weight: bold;
    }

    .row.mb-4 {
        margin-left: -15px;
        /* Đảm bảo khoảng cách lề trong grid */
        margin-right: -15px;
    }

    .col-md-3 {
        flex: 0 0 calc(25% - 30px);
        /* Đảm bảo kích thước 25% và trừ khoảng cách */
        max-width: calc(25% - 30px);
        /* Cân chỉnh với flexbox */
        padding: 0;
    }
    .chart-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin: 20px 0;
    padding: 15px;
}

.chart-box {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s ease;
}

.chart-box.full-width {
    flex: 0 0 100%;
    width: 100%;
}

.chart-box.half-width {
    flex: 0 0 calc(50% - 10px);
    min-width: 400px;
}

.chart-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.chart-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid #eee;
    padding-bottom: 10px;
}
</style>


<script>
google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
    drawRevenueChart();
    drawTopUsersChart();
    drawTopProductsChart();
    drawOrderStatusChart();
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
        colors: ['#2ecc71'],
        chartArea: {width: '90%', height: '80%'},
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        },
        hAxis: {
            title: 'Ngày',
            titleTextStyle: {color: '#333'}
        },
        vAxis: {
            title: 'Doanh thu (VNĐ)',
            titleTextStyle: {color: '#333'}
        }
    };

    var chart = new google.visualization.LineChart(document.getElementById('revenue_chart'));
    chart.draw(data, options);
}

function drawTopUsersChart() {
    var data = google.visualization.arrayToDataTable([
        ['Tên người dùng', 'Số đơn hàng'],
        @foreach ($topUsers as $order)
            ['{{ $order->user->name }}', {{ $order->order_count }}],
        @endforeach
    ]);

    var options = {
        pieHole: 0.4,
        colors: ['#3498db', '#e74c3c', '#f1c40f', '#9b59b6', '#1abc9c'],
        chartArea: {width: '90%', height: '80%'},
        legend: {position: 'right'},
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        }
    };

    var chart = new google.visualization.PieChart(document.getElementById('top_users_chart'));
    chart.draw(data, options);
}

function drawOrderStatusChart() {
    var data = google.visualization.arrayToDataTable([
        ['Trạng thái', 'Số lượng'],
        @foreach ($statusLabels as $index => $label)
            ['{{ $label }}', {{ $statusCounts[$index] }}],
        @endforeach
    ]);

    var options = {
        pieHole: 0.4,
        colors: ['#27ae60', '#e67e22', '#3498db', '#e74c3c', '#95a5a6'],
        chartArea: {width: '90%', height: '80%'},
        legend: {position: 'right'},
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        }
    };

    var chart = new google.visualization.PieChart(document.getElementById('order_status_chart'));
    chart.draw(data, options);
}

function drawTopProductsChart() {
    var data = google.visualization.arrayToDataTable([
        ['Sản phẩm', 'Số lượng bán'],
        @foreach ($topProducts as $product)
            ['{{ $product->product_name }}', {{ $product->total_sold }}],
        @endforeach
    ]);

    var options = {
        bars: 'horizontal',
        colors: ['#3498db'],
        chartArea: {width: '70%', height: '80%'},
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        },
        hAxis: {
            title: 'Số lượng bán',
            titleTextStyle: {color: '#333'}
        }
    };

    var chart = new google.visualization.BarChart(document.getElementById('top_products_chart'));
    chart.draw(data, options);
}
</script>
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
                                        <p class="card-text fs-4"><strong>{{ number_format($todayRevenue, 0, ',', '.') }}
                                                đ</strong></p>
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
                                        <a class="text-white " href="{{ route('admin.orders.index') }}">Xem Tất Cả</a>
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
                                        <a class="text-white " href="{{ route('admin.products.index') }}">Xem Tất Cả</a>
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

                                <div class="card bg-warning text-white">



                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-tags"></i> Số Sản Phẩm Sale
                                        </h5>
                                        <p class="card-text fs-4"><strong>{{ $totalProductsOnSale }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="chart-container">
                            <!-- Revenue Chart - Full Width -->
                            <div class="chart-box full-width">
                                <div class="chart-title">
                                    <i class="fas fa-chart-line mr-2"></i> Doanh Thu Theo Ngày
                                </div>
                                <div id="revenue_chart" style="width: 100%; height: 400px;"></div>
                            </div>

                            <!-- Users and Order Status - Half Width Each -->
                            <div class="chart-box half-width">
                                <div class="chart-title">
                                    <i class="fas fa-users mr-2"></i> Top Khách Hàng
                                </div>
                                <div id="top_users_chart" style="width: 100%; height: 400px;"></div>
                            </div>

                            <div class="chart-box half-width">
                                <div class="chart-title">
                                    <i class="fas fa-tasks mr-2"></i> Trạng Thái Đơn Hàng
                                </div>
                                <div id="order_status_chart" style="width: 100%; height: 400px;"></div>
                            </div>

                            <!-- Products Chart - Full Width -->
                            <div class="chart-box full-width">
                                <div class="chart-title">
                                    <i class="fas fa-trophy mr-2"></i> Top Sản Phẩm Bán Chạy
                                </div>
                                <div id="top_products_chart" style="width: 100%; height: 400px;"></div>
                            </div>

                            <div class="chart-box full-width">
                                <div class="chart-title">
                                    <i class="fas fa-warehouse mr-2"></i> Thống kê tồn kho sản phẩm
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng tồn kho</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>
                                                    {{ $product->variants->sum('total_stock') ?? 0 }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-4">
                                    {{ $products->links() }}
                                </div>
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
        google.charts.load('current', {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawRevenueChart();
            drawTopUsersChart();
            drawTopProductsChart();
            drawOrderStatusChart(); // Thêm dòng này
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
                legend: {
                    position: 'bottom'
                },
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
                colors: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'], // Gắn mảng màu vào biểu đồ
                legend: {
                    position: 'right'
                },
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

                bar: {
                    groupWidth: '75%'
                },
                legend: {
                    position: 'none'
                },
                colors: ['#00FFFF']
            };

            var chart = new google.visualization.BarChart(document.getElementById('top_products_chart'));
            chart.draw(data, options);
        }

        // Thêm hàm vẽ biểu đồ trạng thái
        function drawOrderStatusChart() {
            var data = google.visualization.arrayToDataTable([
                ['Trạng thái', 'Số lượng'],
                @foreach ($statusLabels as $index => $label)
                    ['{{ $label }}', {{ $statusCounts[$index] }}],
                @endforeach
            ]);

            var options = {
                pieHole: 0.4,
                colors: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                legend: {
                    position: 'right'
                },
                title: 'Phân bố trạng thái đơn hàng'
            };

            var chart = new google.visualization.PieChart(document.getElementById('order_status_chart'));
            chart.draw(data, options);
        }
    </script>
@endsection




