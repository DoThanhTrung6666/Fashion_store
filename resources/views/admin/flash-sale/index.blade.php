
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách sản phẩm sale <a class="btn btn-primary" href="{{route('admin.sales.create')}}">Thêm mới sale</a>
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <form action="" method="POST">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Current Discount</th>
                                            <th>Update Discount</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($flashSales as $flashSale)
                                            <tr>
                                                <td>{{ $flashSale->name }}</td>






                                                <td>
                                                    <form action="" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa Flash Sale này không?')">
                                                        @csrf
                                                        @method('DELETE') <!-- Đặt phương thức HTTP là DELETE -->
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-success">Update Discounts</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
