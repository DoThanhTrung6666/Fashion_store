
@extends('layout.admin')

@section('content')
<style>
    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid #eee;
    }

    .tabs a {
        text-decoration: none;
        padding: 10px 15px;
        font-size: 14px;
        color: #555;
        border-bottom: 2px solid transparent;
    }

    .tabs a.active {
        color: #ff5722;
        border-bottom: 2px solid #ff5722;
    }

    .tab-content {
        display: none;
        padding: 20px;
        border: 1px solid #000000;
        border-radius: 5px;
        background-color: #fff;
    }

    .tab-content.active {
        display: block;
    }

    .tabs {
        background: #ffffff;
        /* text-align: center; */
    }

    .tabs a {
        text-align: center;
        margin-left: 4%
    }

    /* Hiển thị dropdown khi di chuột vào */
    .dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Tạo hiệu ứng khi di chuột vào các item trong menu */
    .dropdown-item:hover {
        background-color: #f1f1f1;
        outline: none; /* Loại bỏ viền */
    }
</style>
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách Flash Sale
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="tabs">
                            <a href="?tab=all" class="tab {{ request('tab') == 'all' || !request('tab') ? 'active' : '' }}">Tất cả</a>
                            <a href="?tab=Đang diễn ra" class="tab {{ request('tab') == 'Đang diễn ra' ? 'active' : '' }}"> <i class="fas fa-play-circle" style="color: green;"></i> Đang diễn ra</a>
                            <a href="?tab=Sắp diễn ra" class="tab {{ request('tab') == 'Sắp diễn ra' ? 'active' : '' }}"><i class="fas fa-clock" style="color: orange;"></i> Sắp diễn ra</a>
                            <a href="?tab=Đã kết thúc" class="tab {{ request('tab') == 'Đã kết thúc' ? 'active' : '' }}"> <i class="fas fa-times-circle" style="color: red;"></i> Đã kết thúc</a>
                            <a href="{{route('admin.createFlashSale')}}" class=""><i class="fas fa-plus-circle" style="color: greenyellow"></i> Thêm Flash-Sale mới</a>
                        </div>
                        <div class="box box-primary">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">Tên Flash-Sale</th>
                                            <th style="text-align: center">% giảm giá</th>
                                            <th style="text-align: center">Thời gian bắt đầu</th>
                                            <th style="text-align: center">Thời gian kết thúc</th>
                                            <th style="text-align: center">Trạng thái</th>
                                            {{-- <th style="text-align: center">Thao tác</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (request('tab') == 'all' || !request('tab'))
                                        @foreach($flashSales as $flashSale)
                                            <tr style="">
                                                <td style="text-align: center">{{ $flashSale->name }}</td>
                                                <td style="text-align: center">{{ number_format($flashSale->sale->discount_percentage) }} %</td>
                                                <td style="text-align: center">{{ \Carbon\Carbon::parse($flashSale->start_time)->format('d/m/Y H:i:s') }}</td>
                                                <td style="text-align: center">{{ \Carbon\Carbon::parse($flashSale->end_time)->format('d/m/Y H:i:s') }}</td>
                                                {{-- <td><span class="badge rounded-pill bg-success">{{ $flashSale->status}}</span></td> --}}
                                                <td style="text-align: center">
                                                    @if($flashSale->status == 'Đang diễn ra')
                                                    <span class="badge rounded-pill" style="background-color: rgb(50, 211, 50);">{{ $flashSale->status }}</span>
                                                    @elseif($flashSale->status == 'Sắp diễn ra')
                                                    <span class="badge rounded-pill" style="background-color: orange;">{{ $flashSale->status }}</span>
                                                    @else
                                                    <span class="badge rounded-pill" style="background-color: red;">{{ $flashSale->status }}</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <a href="{{ route('admin.add_products', $flashSale->id) }}" class="btn btn-success">Áp dụng</a>
                                                    <a href="{{ route('admin.view_products',$flashSale->id)}}" class="btn btn-warning">Đã áp dụng</a>
                                                    @if($flashSale->status == 'Sắp diễn ra')
                                                    <a href="" class="btn btn-danger">Sửa</a>
                                                    @endif
                                                </td> --}}
                                            </tr>
                                        @endforeach

                                        @elseif (request('tab') == 'Đang diễn ra')
                                        @foreach($flashSale_dangdienra as $flashSale)
                                            <tr style="text-align: center">
                                                <td>{{ $flashSale->name }}</td>
                                                <td>{{ number_format($flashSale->sale->discount_percentage) }} %</td>
                                                <td>{{ $flashSale->start_time}}</td>
                                                <td>{{ $flashSale->end_time}}</td>
                                                {{-- <td><span class="badge rounded-pill bg-success">{{ $flashSale->status}}</span></td> --}}
                                                <td>
                                                    @if($flashSale->status == 'Đang diễn ra')
                                                    <span class="badge rounded-pill" style="background-color: rgb(50, 211, 50);">{{ $flashSale->status }}</span>
                                                    @elseif($flashSale->status == 'Sắp diễn ra')
                                                    <span class="badge rounded-pill" style="background-color: orange;">{{ $flashSale->status }}</span>
                                                    @else
                                                    <span class="badge rounded-pill" style="background-color: red">{{ $flashSale->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.add_products', $flashSale->id) }}" class="btn btn-success">Áp dụng</a>
                                                    <a href="{{ route('admin.view_products',$flashSale->id)}}" class="btn btn-warning">Đã áp dụng</a>
                                                    @if($flashSale->status == 'Sắp diễn ra')
                                                    <a href="" class="btn btn-danger">Sửa</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @elseif (request('tab') == 'Sắp diễn ra')
                                        @foreach($flashSale_sapdienra as $flashSale)
                                            <tr style="text-align: center">
                                                <td>{{ $flashSale->name }}</td>
                                                <td>{{ number_format($flashSale->sale->discount_percentage) }} %</td>
                                                <td>{{ $flashSale->start_time}}</td>
                                                <td>{{ $flashSale->end_time}}</td>
                                                {{-- <td><span class="badge rounded-pill bg-success">{{ $flashSale->status}}</span></td> --}}
                                                <td>
                                                    @if($flashSale->status == 'Đang diễn ra')
                                                    <span class="badge rounded-pill" style="background-color: rgb(50, 211, 50);">{{ $flashSale->status }}</span>
                                                    @elseif($flashSale->status == 'Sắp diễn ra')
                                                    <span class="badge rounded-pill" style="background-color: orange;">{{ $flashSale->status }}</span>
                                                    @else
                                                    <span class="badge rounded-pill" style="background-color: red">{{ $flashSale->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.add_products', $flashSale->id) }}" class="btn btn-success">Áp dụng</a>
                                                    <a href="{{ route('admin.view_products',$flashSale->id)}}" class="btn btn-warning">Đã áp dụng</a>
                                                    @if($flashSale->status == 'Sắp diễn ra')
                                                    <a href="" class="btn btn-danger">Sửa</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        @foreach($flashSale_daketthuc as $flashSale)
                                            <tr style="text-align: center">
                                                <td>{{ $flashSale->name }}</td>
                                                <td>{{ number_format($flashSale->sale->discount_percentage) }} %</td>
                                                <td>{{ $flashSale->start_time}}</td>
                                                <td>{{ $flashSale->end_time}}</td>
                                                {{-- <td><span class="badge rounded-pill bg-success">{{ $flashSale->status}}</span></td> --}}
                                                <td>
                                                    @if($flashSale->status == 'Đang diễn ra')
                                                    <span class="badge rounded-pill" style="background-color: rgb(50, 211, 50);">{{ $flashSale->status }}</span>
                                                    @elseif($flashSale->status == 'Sắp diễn ra')
                                                    <span class="badge rounded-pill" style="background-color: orange;">{{ $flashSale->status }}</span>
                                                    @else
                                                    <span class="badge rounded-pill" style="background-color: red">{{ $flashSale->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- <a href="{{ route('admin.add_products', $flashSale->id) }}" class="btn btn-success">Áp dụng</a> --}}
                                                    <a href="{{ route('admin.view_products',$flashSale->id)}}" class="btn btn-warning">Đã áp dụng</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{-- <a class="btn btn-success" href="{{route('admin.createFlashSale')}}">Thêm mới Flash-sale</a> --}}
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
