@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách kích cỡ
                </h1>
                <span>
                    @if(session('success'))
                        <p style="color: green">{{session('success')}}</p>
                    @endif
                </span>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    <th>STT</th>
                                    {{-- <th style="text-align: center" scope="col" style=""></th>
                                    <th style="text-align: center" scope="col" style="">id</th> --}}
                                    <th style="text-align: center" scope="col" style="">Size</th>
                                    {{-- <th style="text-align: center">Thao tac</th> --}}
                                </tr>

                               @foreach ($sizes as $key => $size)
                               <tr>
                                <td>{{$key + 1}}</td>
                                {{-- <td style="text-align: center"><input type="checkbox"></td>
                                <td style="text-align: center">{{$size->id}}</td> --}}
                                <td style="text-align: center">{{$size->name}}</td>
                                {{-- <td style="text-align: center;">

                                        <form action="{{route('admin.sizes.destroy',$size->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Xoá</button>
                                        </form>
                                    </td> --}}
                                </tr>
                               @endforeach
                            </table>
                            <a style="margin-bottom: 10px; margin-left:10px" class="btn btn-success" href="{{route('admin.sizes.create')}}">Thêm mới kích cỡ</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
