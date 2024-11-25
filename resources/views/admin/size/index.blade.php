@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách Size <a class="btn btn-primary" href="{{route('admin.sizes.create')}}">Thêm mới size</a>
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
                                    <th style="text-align: center" scope="col" style="">Size</th>

                                </tr>

                               @foreach ($sizes as $size)
                               <tr>
                                <td style="text-align: center"><input type="checkbox"></td>
                                <td style="text-align: center">{{$size->id}}</td>
                                <td style="text-align: center">{{$size->name}}</td>
                                <td style="text-align: center; display: flex">
                                        <a href="{{route('admin.sizes.edit',$size->id)}}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('admin.sizes.destroy',$size->id)}}" method="POST" style="margin-left: 20px">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa ?')" class="btn btn-danger">Xóa</button>
                                        </form>
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
