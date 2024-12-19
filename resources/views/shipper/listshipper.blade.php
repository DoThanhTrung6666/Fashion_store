@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1 style="margin-bottom: 10px; text-align:center">
                    Danh sách shipper 
                </h1>
                {{-- <div class="gray py-3">
                    <div class="row">
                        <div class="colxl-12 col-lg-12 col-md-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Danh sách sản phẩm đang bán</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('admin.listEndProduct')}}">Danh sách sản phẩm ngừng bán</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div> --}}
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <table class="table">
                                <tr>
                                    <th style="text-align: center" scope="col" style="">Tên shipper</th>
                                    <th style="text-align: center" scope="col" style="">Email</th>
                                    <th style="text-align: center" scope="col" style="">Số điện thoại </th>
                                    <th style="text-align: center" scope="col" style="">Giới tính </th>
                                    <th style="text-align: center" scope="col" style="">Ngày sinh </th>
                                </tr>

                               @foreach ($shipper as $shipper)

                                            <tr style="text-align: center">
                                                {{-- <td><input type="checkbox"></td> --}}
                                                {{-- <td>{{$product->id}}</td> --}}
                                                <td>{{$shipper->name}}</td>
                                                <td>{{$shipper->email}}</td>
                                                <td>{{$shipper->phone_number}}</td>
                                                <td>{{$shipper->gender}}</td>
                                                <td>{{$shipper->date_of_birth}}</td>
                                                <td></td>
                                            </tr>


                               @endforeach
                            </table>
                            {{-- <a href="{{route('admin.products.index')}}"><i class="ti-back-left mr-2"></i> Quay lại</a> --}}
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
