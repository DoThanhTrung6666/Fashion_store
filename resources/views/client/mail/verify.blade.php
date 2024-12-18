@component('mail::message')
    # Xác minh tài khoản của bạn

    Nhấn vào nút bên dưới để xác minh tài khoản:

    @component('mail::button', ['url' => $url])
        Xác minh ngay
    @endcomponent

    Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.

    Cảm ơn,<br>
    {{ config('app.name') }}
@endcomponent
