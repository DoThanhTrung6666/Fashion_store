    @extends('layout.admin')

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
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Ngày bắt đầu:</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">Ngày kết thúc:</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                                </div>
                                <div class="col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-primary">Lọc</button>
                                </div>
                            </div>
                        </form>

                        <!-- Doanh thu -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title">Doanh thu</h4>
                                <div id="revenue_chart" style="height: 400px;"></div>
                            </div>
                        </div>

                        <!-- Top người dùng -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title">Người dùng đặt hàng nhiều nhất</h4>
                                <div id="top_users_chart" style="height: 400px;"></div>
                            </div>
                        </div>

                        <!-- Top sản phẩm -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Sản phẩm bán chạy nhất</h4>
                                <div id="top_products_chart" style="height: 400px;"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            
        </section>
    </div>

    <!-- Google Charts Scripts -->

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
                    ['{{ $order->productvariant->product->name }}', {{ $order->total_sold }}],
                    
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