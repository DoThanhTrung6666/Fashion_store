@extends('layout.client')
@section('content')
    <div class="clearfix"></div>
    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->

    <!-- ======================= Top Breadcrubms ======================== -->
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="colxl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            {{-- <li class="breadcrumb-item"><a href="#">Chi tiết</a></li> --}}
                            <li class="breadcrumb-item active" aria-current="page">Flash-sale</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section style="margin-top: 5px">
        <div class="container">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center d-block mb-5">
                        <h2>Flash sale</h2>
                    </div>
                </div>
            </div>

            <div class="sale-container">
                <!-- Đang diễn ra -->
                <div class="sale-box active">
                    <h3>Đang Diễn Ra</h3>
                    <div class="program-list">
                        @if(!$flashSales_dangdienra)
                            <div class="program-item">Không có chương trình nào</div>
                        @else
                            @foreach ($flashSales_dangdienra as $item)
                                <div class="program-item">{{$item->name}}</div>
                            @endforeach
                        @endif
                        {{-- <div class="program-item">Giảm Giá Mùa Đông</div>
                        <div class="program-item">Giảm Giá Hè</div>
                        <div class="program-item">Flash Sale</div>
                        <div class="program-item">Giảm Giá Cuối Năm</div>
                        <div class="program-item">Giảm Giá Black Friday</div>
                        <div class="program-item">Giảm Giá Tết</div> --}}
                    </div>
                </div>

                <!-- Sắp diễn ra -->
                <div class="sale-box upcoming">
                    <h3>Sắp Diễn Ra</h3>
                    <div class="program-list">
                        @foreach ($flashSales_sapdienra as $item)
                            <div class="program-item">Giảm Giá Mùa Đông</div>
                        @endforeach
                        {{-- <div class="program-item">Giảm Giá Lễ Tết Nguyên Đán</div>
                        <div class="program-item">Giảm Giá Mùa Thu</div> --}}
                    </div>
                </div>
            </div>




        </div>
    </section>
@endsection

<style>
    /* Container chung */
.sale-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin: 20px;
    flex-wrap: wrap; /* Cho phép các ô xuống dòng nếu cần */
}

/* Box Sale */
.sale-box {
    width: 48%;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    height: auto;
    margin-bottom: 20px;
}

/* Tiêu đề của box sale */
.sale-box h3 {
    margin-bottom: 20px;
}

/* Danh sách các chương trình giảm giá */
.program-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Các chương trình giảm giá */
.program-item {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-size: 18px;
    font-weight: normal;
    transition: transform 0.3s ease;
    text-align: left;
    width: 100%;
}

/* Hiệu ứng hover cho mỗi chương trình */
.program-item:hover {
    transform: scale(1.05);
}

/* Màu sắc cho từng phần */
.sale-box.active {
    background-color: #e8f5e9; /* Xanh lá đậm */
    border-left: 5px solid #4caf50; /* Đường viền xanh lá */
}

.sale-box.upcoming {
    background-color: #f1f8e9; /* Xanh lá nhạt */
    border-left: 5px solid #8bc34a; /* Đường viền xanh lá nhạt */
}

</style>
