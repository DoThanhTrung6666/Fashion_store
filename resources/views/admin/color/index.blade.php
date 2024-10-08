@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách Color <a class="btn btn-primary" href="">Thêm mới Color</a>
                </h1>
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
                                <td style="text-align: center"><label class="color-radio" style="background-color: {{$color->name}};"></label></td>
                                <td style="text-align: center">
                                        <a href="" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('colors.destroy',$color->id)}}" method="POST" class="btn btn-danger">
                                            @csrf
                                            @method('delete')
                                            <button type="submit">Xóa</button>
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
