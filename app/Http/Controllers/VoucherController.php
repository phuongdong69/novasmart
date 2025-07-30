<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::with(['status', 'user'])->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $statuses = \App\Models\Status::getByType('voucher');
        return view('admin.vouchers.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code|max:50',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'nullable|exists:users,id',
            // 'is_public' => 'nullable|boolean',
        ], [
            'code.required' => 'Mã voucher không được để trống',
            'code.unique' => 'Mã voucher đã tồn tại',
            'code.max' => 'Mã voucher không được quá 50 ký tự',
            'type.required' => 'Loại giảm giá không được để trống',
            'type.in' => 'Loại giảm giá không hợp lệ',
            'value.required' => 'Giá trị giảm không được để trống',
            'value.numeric' => 'Giá trị giảm phải là số',
            'value.min' => 'Giá trị giảm phải lớn hơn 0',
            'max_discount.numeric' => 'Mức giảm tối đa phải là số',
            'max_discount.min' => 'Mức giảm tối đa phải lớn hơn 0',
            'min_order_value.required' => 'Giá trị đơn hàng tối thiểu không được để trống',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là số',
            'min_order_value.min' => 'Giá trị đơn hàng tối thiểu phải lớn hơn 0',
            'usage_limit.required' => 'Số lần sử dụng tối đa không được để trống',
            'usage_limit.integer' => 'Số lần sử dụng tối đa phải là số nguyên',
            'usage_limit.min' => 'Số lần sử dụng tối đa phải lớn hơn 0',
            'start_date.required' => 'Ngày bắt đầu không được để trống',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ',
            'end_date.required' => 'Ngày kết thúc không được để trống',
            'end_date.date' => 'Ngày kết thúc không hợp lệ',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
            'user_id.exists' => 'Người dùng không tồn tại',
            'is_public.boolean' => 'Trạng thái công khai không hợp lệ',
        ]);

        $data = $request->all();
        // Xử lý checkbox is_public - chỉ true khi được check
        $data['is_public'] = $request->has('is_public');
        // Xử lý user_id nếu là empty string
        if (empty($data['user_id'])) {
            $data['user_id'] = null;
        }
        // Lấy status theo code
        if (!empty($data['status_code'])) {
            $status = \App\Models\Status::findByCodeAndType($data['status_code'], 'voucher');
            if ($status) {
                $data['status_id'] = $status->id;
            }
        } else {
            // Mặc định Hoạt động
            $status = \App\Models\Status::where('type', 'voucher')->where('code', 'active')->first();
            $data['status_id'] = $status?->id;
            $data['status_code'] = $status?->code;
        }
        Voucher::create($data);
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được tạo thành công.');
    }

    public function show(Voucher $voucher)
    {
        $voucher->load(['status', 'user', 'usages.user', 'usages.order']);
        return view('admin.vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        $statuses = \App\Models\Status::getByType('voucher');
        return view('admin.vouchers.edit', compact('voucher', 'statuses'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        // Debug: Log request data
        \Illuminate\Support\Facades\Log::info('Voucher Update Request:', $request->all());
        
        $request->validate([
            'code' => 'required|max:50|unique:vouchers,code,' . $voucher->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'nullable|exists:users,id',
            // 'is_public' => 'nullable|boolean',
        ], [
            'code.required' => 'Mã voucher không được để trống',
            'code.unique' => 'Mã voucher đã tồn tại',
            'code.max' => 'Mã voucher không được quá 50 ký tự',
            'type.required' => 'Loại giảm giá không được để trống',
            'type.in' => 'Loại giảm giá không hợp lệ',
            'value.required' => 'Giá trị giảm không được để trống',
            'value.numeric' => 'Giá trị giảm phải là số',
            'value.min' => 'Giá trị giảm phải lớn hơn 0',
            'max_discount.numeric' => 'Mức giảm tối đa phải là số',
            'max_discount.min' => 'Mức giảm tối đa phải lớn hơn 0',
            'min_order_value.required' => 'Giá trị đơn hàng tối thiểu không được để trống',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là số',
            'min_order_value.min' => 'Giá trị đơn hàng tối thiểu phải lớn hơn 0',
            'usage_limit.required' => 'Số lần sử dụng tối đa không được để trống',
            'usage_limit.integer' => 'Số lần sử dụng tối đa phải là số nguyên',
            'usage_limit.min' => 'Số lần sử dụng tối đa phải lớn hơn 0',
            'start_date.required' => 'Ngày bắt đầu không được để trống',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ',
            'end_date.required' => 'Ngày kết thúc không được để trống',
            'end_date.date' => 'Ngày kết thúc không hợp lệ',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
            'user_id.exists' => 'Người dùng không tồn tại',
            'is_public.boolean' => 'Trạng thái công khai không hợp lệ',
        ]);

        $data = $request->all();
        // Xử lý checkbox is_public - chỉ true khi được check
        $data['is_public'] = $request->has('is_public');
        
        // Xử lý user_id nếu là empty string
        if (empty($data['user_id'])) {
            $data['user_id'] = null;
        }

        // Lấy status theo code
        if (!empty($data['status_code'])) {
            $status = \App\Models\Status::findByCodeAndType($data['status_code'], 'voucher');
            if ($status) {
                $data['status_id'] = $status->id;
            }
        }

        // Debug: Log processed data
        \Illuminate\Support\Facades\Log::info('Voucher Update Data:', $data);

        try {
            $voucher->update($data);
            return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được cập nhật thành công.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Voucher Update Error:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật voucher: ' . $e->getMessage()]);
        }
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được xóa thành công.');
    }

    public function usages(Voucher $voucher)
    {
        $voucher->load(['usages.user', 'usages.order']);
        return view('admin.vouchers.usages', compact('voucher'));
    }

    public function allUsages()
    {
        $usages = \App\Models\VoucherUsage::with(['voucher', 'user', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.vouchers.all_usages', compact('usages'));
    }

    // API method để validate và apply voucher
    public function validateVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_total' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher không tồn tại trong hệ thống'
            ], 400);
        }

        // Kiểm tra thời gian hiệu lực
        if (!$voucher->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher đã hết hạn hoặc không còn hiệu lực'
            ], 400);
        }

        // Kiểm tra user có thể sử dụng voucher không
        if (!$voucher->canBeUsedByUser($request->user_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã sử dụng voucher này rồi'
            ], 400);
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($request->order_total < $voucher->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng phải có giá trị tối thiểu ' . number_format($voucher->min_order_value) . ' VNĐ'
            ], 400);
        }

        // Tính toán giá trị giảm
        $discountAmount = $voucher->calculateDiscount($request->order_total);

        return response()->json([
            'success' => true,
            'voucher' => $voucher,
            'discount_amount' => $discountAmount,
            'final_total' => $request->order_total - $discountAmount
        ]);
    }

    // Method để apply voucher vào order
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_id' => 'required|exists:vouchers,id',
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        $voucher = Voucher::findOrFail($request->voucher_id);
        $order = \App\Models\Order::findOrFail($request->order_id);

        // Tạo voucher usage record
        VoucherUsage::create([
            'voucher_id' => $voucher->id,
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'discount_amount' => $request->discount_amount,
        ]);

        // Cập nhật số lần sử dụng voucher
        $voucher->incrementUsage();

        // Cập nhật order với voucher và giảm giá
        $order->update([
            'voucher_id' => $voucher->id,
            'total_price' => $order->total_price - $request->discount_amount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Voucher đã được áp dụng thành công'
        ]);
    }
}

