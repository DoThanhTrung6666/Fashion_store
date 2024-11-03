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

                        <table class="table">
                            <tr>
                                <th style="text-align: center" scope="col" style=""></th>
                                <th style="text-align: center" scope="col" style="">STT</th>
                                <th style="text-align: center" scope="col" style="">Tên sản phẩm</th>
                                <th style="text-align: center" scope="col" style="">Ảnh</th>
                                <th style="text-align: center" scope="col" style="">Tổng số bình luận<th>
                            </tr>

                            @foreach ($products as $product)
                                <tr style="text-align: center">
                                    <td><input type="checkbox"></td>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td><img src="{{ Storage::url($product->image) }}" width="100" height="100"
                                            alt=""></td>
                                    <td>{{ $product->comments_count }}</td>
                                    <td>
                                        <a href="{{route('admin.comment.show', $product->id)}}" class="btn btn-warning">Chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
