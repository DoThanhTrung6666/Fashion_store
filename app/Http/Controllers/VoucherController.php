<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Tên voucher
            'discount_percentage' => 'required|numeric|min:0|max:100', // Giảm giá %
            'max_discount' => 'required|numeric|min:0', // Giá giảm tối đa
            'min_order_value' => 'required|numeric|min:0', // Đơn tối thiểu
            'start_date' => 'required|date', // Ngày bắt đầu
            'end_date' => 'required|date|after_or_equal:start_date', // Ngày kết thúc
        ], [
            // Tuỳ chỉnh thông báo lỗi cho từng trường
            'name.required' => 'Vui lòng nhập tên voucher.',
            'name.string' => 'Tên voucher phải là chuỗi ký tự.',
            'name.max' => 'Tên voucher không được vượt quá 255 ký tự.',

            'discount_percentage.required' => 'Vui lòng nhập giá giảm.',
            'discount_percentage.numeric' => 'Giảm giá phải là một số.',
            'discount_percentage.min' => 'Giảm giá phải lớn hơn hoặc bằng 0.',
            'discount_percentage.max' => 'Giảm giá không được vượt quá 100.',

            'max_discount.required' => 'Vui lòng nhập giá giảm tối đa.',
            'max_discount.numeric' => 'Giá giảm tối đa phải là một số.',
            'max_discount.min' => 'Giá giảm tối đa phải lớn hơn hoặc bằng 0.',

            'min_order_value.required' => 'Vui lòng nhập giá trị đơn hàng tối thiểu.',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
            'min_order_value.min' => 'Giá trị đơn hàng tối thiểu phải lớn hơn hoặc bằng 0.',

            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',

            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải là ngày sau hoặc bằng ngày bắt đầu.',
        ]);

        // Thêm logic tùy chỉnh để kiểm tra min_order_value > max_discount
        $validator->after(function ($validator) use ($request) {
            if ($request->has('max_discount') && $request->has('min_order_value')) {
                if ($request->input('min_order_value') <= $request->input('max_discount')) {
                    $validator->errors()->add('min_order_value', 'Giá trị đơn hàng tối thiểu phải lớn hơn giá giảm tối đa.');
                }
            }
        });

        // Kiểm tra lỗi xác thực
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        // Lấy ngày hiện tại
        $currentDate = now();

        // So sánh với ngày bắt đầu và kết thúc để xác định status
        if ($currentDate < $data['start_date']) {
            // Nếu ngày hiện tại trước ngày bắt đầu
            $status = 1; // Chưa bắt đầu
        } elseif ($currentDate >= $data['start_date'] && $currentDate <= $data['end_date']) {
            // Nếu ngày hiện tại nằm trong khoảng ngày bắt đầu và ngày kết thúc
            $status = 2; // Đang diễn ra
        } else {
            // Nếu ngày hiện tại sau ngày kết thúc
            $status = 3; // Đã hết hạn
        }

        // Thêm giá trị status vào dữ liệu trước khi tạo voucher
        $data['status'] = $status;

        // Tạo voucher mới
        Voucher::query()->create($data);

        // Quay lại trang danh sách với thông báo thành công
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được tạo thành công.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Tên voucher
            'discount_percentage' => 'required|numeric|min:0|max:100', // Giảm giá %
            'max_discount' => 'required|numeric|min:0', // Giá giảm tối đa
            'min_order_value' => 'required|numeric|min:0', // Đơn tối thiểu
            'start_date' => 'required|date', // Ngày bắt đầu
            'end_date' => 'required|date|after_or_equal:start_date', // Ngày kết thúc
        ], [
            // Tuỳ chỉnh thông báo lỗi cho từng trường
            'name.required' => 'Vui lòng nhập tên voucher.',
            'name.string' => 'Tên voucher phải là chuỗi ký tự.',
            'name.max' => 'Tên voucher không được vượt quá 255 ký tự.',

            'discount_percentage.required' => 'Vui lòng nhập giá giảm.',
            'discount_percentage.numeric' => 'Giảm giá phải là một số.',
            'discount_percentage.min' => 'Giảm giá phải lớn hơn hoặc bằng 0.',
            'discount_percentage.max' => 'Giảm giá không được vượt quá 100.',

            'max_discount.required' => 'Vui lòng nhập giá giảm tối đa.',
            'max_discount.numeric' => 'Giá giảm tối đa phải là một số.',
            'max_discount.min' => 'Giá giảm tối đa phải lớn hơn hoặc bằng 0.',

            'min_order_value.required' => 'Vui lòng nhập giá trị đơn hàng tối thiểu.',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
            'min_order_value.min' => 'Giá trị đơn hàng tối thiểu phải lớn hơn hoặc bằng 0.',

            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',

            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải là ngày sau hoặc bằng ngày bắt đầu.',
        ]);

        // Thêm logic tùy chỉnh để kiểm tra min_order_value > max_discount
        $validator->after(function ($validator) use ($request) {
            if ($request->has('max_discount') && $request->has('min_order_value')) {
                if ($request->input('min_order_value') <= $request->input('max_discount')) {
                    $validator->errors()->add('min_order_value', 'Giá trị đơn hàng tối thiểu phải lớn hơn giá giảm tối đa.');
                }
            }
        });

        // Kiểm tra lỗi xác thực
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $voucher = Voucher::findOrFail($id);
        $currentDate = now();

        // So sánh với ngày bắt đầu và kết thúc để xác định status
        if ($currentDate < $data['start_date']) {
            // Nếu ngày hiện tại trước ngày bắt đầu
            $status = 1; // Chưa bắt đầu
        } elseif ($currentDate >= $data['start_date'] && $currentDate <= $data['end_date']) {
            // Nếu ngày hiện tại nằm trong khoảng ngày bắt đầu và ngày kết thúc
            $status = 2; // Đang diễn ra
        } else {
            // Nếu ngày hiện tại sau ngày kết thúc
            $status = 3; // Đã hết hạn
        }

        // Thêm giá trị status vào dữ liệu trước khi tạo voucher
        $data['status'] = $status;
        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được cập nhật thành công.');
    }


    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được xóa thành công.');
    }
}
