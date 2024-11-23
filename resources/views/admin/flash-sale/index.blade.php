
@extends('layout.admin')

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Danh sách sản phẩm sale <a class="btn btn-primary" href="{{route('admin.sales.create')}}">Thêm mới sale</a>
                </h1>
            </section>
            <section class="content">
                <div class="row container-fluid">
                    <div class="col-md-12">
                        <div class="box box-primary">

                            <form action="" method="POST">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Current Discount</th>
                                            <th>Update Discount</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($flashSales as $flashSale)
                                            <tr>
                                                <td>{{ $flashSale->productVariant->product->name }} ({{ $flashSale->productVariant->color->name }} - {{ $flashSale->productVariant->size->name }})</td>

                                                <td>
                                                    @if($flashSale->sale)
                                                        {{ $flashSale->sale->discount_percentage }}% ({{ $flashSale->sale->name }})
                                                    @else
                                                        No discount
                                                    @endif
                                                </td>

                                                <td>
                                                    <select name="flash_sales[{{ $flashSale->id }}][sale_id]" class="form-control">
                                                        <option value="">Select Discount</option>
                                                        @foreach ($sales as $sale)
                                                            <option value="{{ $sale->id }}" {{ $flashSale->sale_id == $sale->id ? 'selected' : '' }}>
                                                                {{ $sale->name }} - {{ $sale->discount_percentage }}%
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="datetime-local" name="flash_sales[{{ $flashSale->id }}][start_time]" class="form-control" value="{{ \Carbon\Carbon::parse($flashSale->start_time)->format('Y-m-d\TH:i') }}" required>
                                                </td>

                                                <td>
                                                    <input type="datetime-local" name="flash_sales[{{ $flashSale->id }}][end_time]" class="form-control" value="{{ \Carbon\Carbon::parse($flashSale->end_time)->format('Y-m-d\TH:i') }}" required>
                                                </td>

                                                <td>
                                                    <select name="flash_sales[{{ $flashSale->id }}][status]" class="form-control" required>
                                                        <option value="active" {{ $flashSale->status == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ $flashSale->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-success">Update Discounts</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
