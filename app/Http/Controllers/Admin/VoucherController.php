<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        // Lấy ID trạng thái "hết hạn"
        $expiredStatus = Status::where('type', 'voucher')->where('name', 'Hết hạn')->first();

        // Nếu tìm thấy trạng thái hết hạn thì cập nhật các voucher quá hạn
        if ($expiredStatus) {
            Voucher::where('expired_at', '<', now())
                ->where('status_id', '!=', $expiredStatus->id)
                ->update(['status_id' => $expiredStatus->id]);
        }

        $vouchers = Voucher::with('status')->latest()->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }


    public function create()
    {
        $statuses = Status::where('type', 'voucher')->get();
        return view('admin.vouchers.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:vouchers,code|max:50',
            'description' => 'nullable|max:255',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:0',
            'expired_at' => 'required|date|after:now',
            'status_id' => 'required|exists:statuses,id',
        ], [
            'code.required' => 'Vui lòng nhập mã giảm giá.',
            'code.unique' => 'Mã giảm giá đã tồn tại.',
            'code.max' => 'Mã giảm giá không được vượt quá 50 ký tự.',
            'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ.',
            'discount_value.required' => 'Vui lòng nhập giá trị giảm.',
            'discount_value.numeric' => 'Giá trị giảm phải là số.',
            'discount_value.min' => 'Giá trị giảm phải lớn hơn 0.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng không được nhỏ hơn 0.',
            'expired_at.required' => 'Vui lòng chọn ngày hết hạn.',
            'expired_at.date' => 'Ngày hết hạn không hợp lệ.',
            'expired_at.after' => 'Ngày hết hạn phải sau thời điểm hiện tại.',
            'status_id.required' => 'Vui lòng chọn trạng thái.',
            'status_id.exists' => 'Trạng thái không tồn tại.',
        ]);

        Voucher::create($validated);
        return redirect()->route('admin.vouchers.index')->with('success', 'Tạo voucher thành công!');
    }

    public function edit(Voucher $voucher)
    {
        $statuses = Status::where('type', 'voucher')->get();
        if ($voucher->expired_at) {
            $voucher->expired_at = Carbon::parse($voucher->expired_at);
        }
        return view('admin.vouchers.edit', compact('voucher', 'statuses'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'code' => 'required|max:50|unique:vouchers,code,' . $voucher->id,
            'description' => 'nullable|max:255',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:0',
            'expired_at' => 'required|date|after:now',
            'status_id' => 'required|exists:statuses,id',
        ], [
            'code.required' => 'Vui lòng nhập mã giảm giá.',
            'code.unique' => 'Mã giảm giá đã tồn tại.',
            'code.max' => 'Mã giảm giá không được vượt quá 50 ký tự.',
            'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ.',
            'discount_value.required' => 'Vui lòng nhập giá trị giảm.',
            'discount_value.numeric' => 'Giá trị giảm phải là số.',
            'discount_value.min' => 'Giá trị giảm phải lớn hơn 0.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng không được nhỏ hơn 0.',
            'expired_at.required' => 'Vui lòng chọn ngày hết hạn.',
            'expired_at.date' => 'Ngày hết hạn không hợp lệ.',
            'expired_at.after' => 'Ngày hết hạn phải sau thời điểm hiện tại.',
            'status_id.required' => 'Vui lòng chọn trạng thái.',
            'status_id.exists' => 'Trạng thái không tồn tại.',
        ]);

        $voucher->update($validated);
        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật voucher thành công!');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Xóa voucher thành công!');
    }
}
