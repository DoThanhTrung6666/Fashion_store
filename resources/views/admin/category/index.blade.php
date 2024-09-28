@extends('layout.admin')
@section('content')
    <section class="content-header">
        <h1>
            Danh sách danh mục
        </h1>
    </section>
    <section class="content">
        <div class="row container-fluid">
            <div class="col-md-11">
                <div class="box box-primary">
                    <table class="table">
                        <tr>
                            <th scope="col" class="col-1"></th>
                            <th scope="col" class="col-3">Tiêu đề</th>
                            <th scope="col" class="col-4">Nội dung</th>
                            <th scope="col" class="col-2">Chuyên mục</th>
                            <th scope="col" class="col-2">Thao tác</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Siêu đội hình kết hợp Hà Lan - Anh</td>
                            <td>Hà Lan và Anh chuẩn bị gặp nhau ở bán kết EURO 2024 (2h, 11/7). Do trong đội
                                hình có rất nhiều ngôi sao sáng giá nên họ tạo ra được đội hình kết hợp khá chất
                                lượng.
                            <td>Thể thao</td>
                            <td>
                                <button class="btn btn-success">Sửa</button>
                                <button class="btn btn-danger">Xóa</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
