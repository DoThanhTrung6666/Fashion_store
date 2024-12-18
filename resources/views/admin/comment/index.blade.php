@extends('layout.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Danh sách bình luận
            </h1>
        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="text-align: center">cập nhật mới nhất ngày</th>
                                    <th style="text-align: center">Mã đơn hàng</th>
                                    <th style="text-align: center">Tên sản phẩm</th>
                                    <th style="text-align: center">Ảnh</th>
                                    <th style="text-align: center">Lượt đánh giá</th>
                                    <th style="text-align: center">Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                    @php
                                        $orderDisplayed = false;
                                        $rowClass = $index % 2 == 0 ? 'bg-light' : ''; // Thêm class để tạo màu nền phân biệt
                                    @endphp
                                    @foreach ($order->orderItems as $item)
                                        <tr class="{{ $rowClass }}" style="text-align: center">
                                            <td>
                                                @php
                                                    $latestCommentDate = $item->productVariant->comments->max('updated_at');
                                                @endphp
                                                {{ $latestCommentDate ? \Carbon\Carbon::parse($latestCommentDate)->format('d/m/Y H:i') : ' ' }}
                                            </td>
                                            <!-- Chỉ hiển thị mã đơn hàng trong lần lặp đầu tiên của mỗi đơn hàng -->
                                            @if (!$orderDisplayed)
                                                <td>{{ $order->id }}</td>
                                                @php $orderDisplayed = true; @endphp
                                            @else
                                                <td></td> <!-- Không hiển thị mã đơn hàng ở các lần sau -->
                                            @endif
                                            
                                            <td>{{ $item->productVariant->product->name }}</td>
                                            <td>
                                                <img src="{{ Storage::url($item->productVariant->product->image) }}" width="100" height="100" alt="Ảnh sản phẩm">
                                            </td>
                                            <td>
                                                {{ $item->productVariant->comments->avg('rating') ? number_format($item->productVariant->comments->avg('rating'), 1) : 'Chưa có bình luận' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.comment.show', ['order_id' => $order->id, 'product_id' => $item->productVariant->product->id, 'product_variant_id' => $item->product_variant_id]) }}" class="btn btn-warning btn-sm">Chi tiết</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
