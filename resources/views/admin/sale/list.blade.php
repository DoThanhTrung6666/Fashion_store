
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
                                    {{-- <th style="text-align: center" scope="col" style=""></th> --}}

                                    <th style="text-align: center" scope="col" style="">Phần trăm giảm giá</th>
                                    <th style="text-align: center">Thao tác</th>
                                </tr>

                               @foreach ($sales as $sale)
                               <tr>
                                {{-- <td style="text-align: center"><input type="checkbox"></td> --}}

                                <td style="text-align: center">{{number_format($sale->discount_percentage)}}%</td>
                                <td style="text-align: center">
                                        <a href="{{route('admin.sales.edit',$sale->id)}}" class="btn btn-warning">Sửa</a>
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
