
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách loại sale <a class="btn btn-primary" href="{{route('admin.sales.create')}}">Thêm mới sale</a>
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    <th style="text-align: center" scope="col" style=""></th>
                                    <th style="text-align: center" scope="col" style="">Tên giảm giá</th>
                                    <th style="text-align: center" scope="col" style="">Phần trăm giảm giá</th>

                                </tr>

                               @foreach ($sales as $sale)
                               <tr>
                                <td style="text-align: center"><input type="checkbox"></td>
                                <td style="text-align: center">{{$sale->name}}</td>
                                <td style="text-align: center">{{$sale->discount_percentage}}%</td>
                                <td style="text-align: center">
                                        <a href="" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('admin.sales.destroy',$sale->id)}}" method="POST" class="btn btn-danger">
                                            @csrf
                                            @method('delete')
                                            <button type="submit">Xoa</button>
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
