@extends('layout.client')
@section('content')
<section class="middle gray">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">San pham yeu thich</h2>
                    <h3 class="ft-bold pt-3">San pham yeu thich</h3>
                </div>
            </div>
        </div>

        <!-- row -->
        <div class="row align-items-center rows-products">

            @foreach ($favorites as $value)


            <!-- Single -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                <div class="product_grid card b-0">
                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper"></div>
                    <div class="card-body p-0">
                        <div class="shop_thumb position-relative">
                            <a class="card-img-top d-block overflow-hidden" href="{{ route('detail.show',$value->id)}}"><img class="card-img-top" src="{{Storage::url($value->image)}}" alt="..."></a>
                            <div class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center">
                                <div class="edlio"><a href="{{ route('detail.show',$value->id)}}" class="text-white fs-sm ft-medium"><i class="fas fa-eye mr-1"></i>Quick View</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer b-0 p-0 pt-2">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="text-left">
                                {{-- @foreach ($trending->variants as $color)
                                <div class="form-check form-option form-check-inline mb-1">
                                    <input class="form-check-input" type="radio" name="color1" id="white" checked="">
                                    <label class="form-option-label small rounded-circle" for="white" style="background-color: {{$color->color->name}};">
                                        {{$color->color->name}}
                                    </label> --}}
                                    {{-- <label class="color-radio" style="background-color: {{$color->name}};"></label> --}}
                                {{-- </div>
                                @endforeach --}}
                                <div class="form-check form-option form-check-inline mb-1">
                                    Lượt xem : {{$value->views}}
                                </div>
                            </div>
                            <div class="text-right">
                                <form  action="{{route('favorites.delete',$value->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn auto btn_love snackbar-wishlist"><i class="far fa-heart"></i></button>
                                    {{-- <button type="submit">Them vao yeu thich</button> --}}
                                </form>
                            </div>
                        </div>
                        <div class="text-left">
                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{ route('detail.show',$value->id)}}">{{$value->name}}</a></h5>
                            <div class="elis_rty"><span class="ft-bold text-dark fs-sm">{{number_format($value->price)}} vnđ</span></div>
                        </div>
                    </div>
                </div>

            </div>

            @endforeach

        </div>
        {{-- {{ $trendingProducts->links() }} --}}
        <!-- row -->



    </div>
</section>
@endsection