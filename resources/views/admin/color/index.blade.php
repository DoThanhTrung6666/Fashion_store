@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách Color <a class="btn btn-primary" href="{{route('admin.colors.create')}}">Thêm mới Color</a>
                </h1>
                <span>
                    @if(session('success'))
                        <p style="color: red">{{session('success')}}</p>
                    @endif
                </span>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    <th style="text-align: center" scope="col" style=""></th>
                                    <th style="text-align: center" scope="col" style="">id</th>
                                    <th style="text-align: center" scope="col" style="">Color</th>

                                </tr>

                               @foreach ($colors as $color)
                               <tr>
                                <td style="text-align: center"><input type="checkbox"></td>
                                <td style="text-align: center">{{$color->id}}</td>
                                <td style="text-align: center">{{$color->name}}</td>
                                <td style="text-align: center; display: flex;">
                                        <a href="{{route('admin.colors.edit',$color->id)}}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('admin.colors.destroy',$color->id)}}" method="POST" style="margin-left: 20px">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không')" class="btn btn-danger">Xóa</button>
                                        </form>
                                        {{-- <a href="{{ route('admin.colors.destroy',$color->id)}}" class="btn btn-danger">Xóa </a> --}}
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
