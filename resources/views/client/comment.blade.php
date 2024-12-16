@extends('layout.client')

@section('content') <!-- Bắt đầu section 'content' -->

<!-- Form gửi bình luận -->
<div class="add-review">
    <form action="{{ route('comment.store', ['orderId' => $order->id, 'productVariantId' => $product_variant_id]) }}" method="POST">
        @csrf
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <h4>Submit Rating</h4>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
                <div class="srt_013">
                    <div class="submit-rating" valida>
                        <!-- Rating Stars as Radio Buttons -->
                        <input id="star-5" type="radio" name="rating" value="5" />
                        <label for="star-5" title="5 stars">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input id="star-4" type="radio" name="rating" value="4" />
                        <label for="star-4" title="4 stars">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input id="star-3" type="radio" name="rating" value="3" />
                        <label for="star-3" title="3 stars">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input id="star-2" type="radio" name="rating" value="2" />
                        <label for="star-2" title="2 stars">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                        <input id="star-1" type="radio" name="rating" value="1" />
                        <label for="star-1" title="1 star">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="content">Your Comment</label>
                <textarea name="content" id="content" class="form-control" rows="4"></textarea>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection <!-- Kết thúc section 'content' -->


<script>
    // Lấy tất cả các sao
    const stars = document.querySelectorAll('.star-rating i');
    const ratingInput = document.getElementById('rating');  // Input ẩn để lưu rating

    // Lặp qua các sao và thêm sự kiện click
    stars.forEach(star => {
        star.addEventListener('click', function() {
            // Lấy giá trị của sao (1 - 5)
            const rating = this.getAttribute('data-value');

            // Cập nhật giá trị rating vào input ẩn
            ratingInput.value = rating;

            // Cập nhật giao diện sao
            updateStars(rating);
        });
    });

    // Hàm để cập nhật giao diện sao
    function updateStars(rating) {
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= rating) {
                star.classList.add('filled');  // Đổi sao thành màu vàng khi đã chọn
            } else {
                star.classList.remove('filled');  // Đổi lại màu mặc định khi chưa chọn
            }
        });
    }

</script>

<style>
    .fas.fa-star.filled {
        color: #ffcc00;  /* Màu vàng cho sao đã chọn */
    }
    .fas.fa-star {
        color: #ddd;  /* Màu xám cho sao chưa chọn */
        cursor: pointer;  /* Thêm con trỏ chuột khi hover */
    }
</style>
