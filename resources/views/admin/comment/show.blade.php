@extends('layout.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Chi tiết bình luận
            </h1>
        </section>
        <section class="content">
            <div class="row container-fluid">
                <div class="col-md-12">
                    <div class="box box-primary">

                        <table class="table">
                            <tr>
                                <th style="text-align: center" scope="col" style=""></th>
                                <th style="text-align: center" scope="col" style="">ID</th>
                                <th style="text-align: center" scope="col" style="">Tên người bình luận</th>
                                <th style="text-align: center" scope="col" style="">Nội dung</th>
                                <th style="text-align: center" scope="col" style="">Ngày bình luận</th>
                            </tr>

                            @foreach ($comments as $comment)
                                <tr style="text-align: center">
                                    <td><input type="checkbox"></td>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->name }}</td>
                                    <td>{{ $comment->content }}</td>
                                    <td>{{ $comment->created_at }}</td>
                                    <form action="{{ route('admin.comment.destroy', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <td>
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Bạn có muốn xóa không?')">Xóa</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
