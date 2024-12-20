@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách màu sắc
                </h1>
                <span>
                    @if(session('success'))
                        <p style="color: red">{{session('success')}}</p>
                    @endif
                </span>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-9">
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    <th style="text-align: center" scope="col" style="">STT</th>
                                    {{-- <th style="text-align: center" scope="col" style="">id</th> --}}
                                    <th style="text-align: center" scope="col" style="">Màu sắc </th>
                                    {{-- <th style="text-align: center" scope="col" style="">Thao tác </th> --}}
                                </tr>

                               @foreach ($colors as $key => $color)
                               <tr>
                                <td  style="text-align: center">{{$key+1}}</td>
                                {{-- <td style="text-align: center"><input type="checkbox"></td>
                                <td style="text-align: center">{{$color->id}}</td> --}}
                                <td style="text-align: center">{{$color->name}}</td>
                                <td style="text-align: center;">
                                    <form action="{{route('admin.color.update.status',$color->id)}}" method="POST">
                                        @csrf
                                        {{-- <button class="btn btn-danger" type="submit">Ngừng hoạt động</button> --}}
                                    </form>
                                </td>
                                </tr>
                               @endforeach
                            </table>
                            <a style="margin-bottom: 10px; margin-left:10px" style="text-align: center" class="btn btn-success" href="{{route('admin.colors.create')}}">Thêm mới màu sắc</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
