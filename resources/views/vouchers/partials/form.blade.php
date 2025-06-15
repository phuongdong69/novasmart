<div class="row g-3">
    <div class="col-md-6">
        <label for="code" class="form-label">Mã Voucher</label>
        <input type="text" class="form-control" id="code" name="code"
            value="{{ old('code', $voucher->code ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="discount_type" class="form-label">Loại Giảm Giá</label>
        <select class="form-select" id="discount_type" name="discount_type" required>
            <option value="percentage" {{ (old('discount_type', $voucher->discount_type ?? '') === 'percentage') ? 'selected' : '' }}>Phần trăm (%)</option>
            <option value="fixed" {{ (old('discount_type', $voucher->discount_type ?? '') === 'fixed') ? 'selected' : '' }}>Cố định (VNĐ)</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="discount_value" class="form-label">Giá Trị Giảm</label>
        <input type="number" class="form-control" id="discount_value" name="discount_value" step="0.01"
            value="{{ old('discount_value', $voucher->discount_value ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="expiry_date" class="form-label">Ngày Hết Hạn</label>
        <input type="date" class="form-control" id="expiry_date" name="expiry_date"
            value="{{ old('expiry_date', $voucher->expiry_date ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="quantity" class="form-label">Số Lượng</label>
        <input type="number" class="form-control" id="quantity" name="quantity"
            value="{{ old('quantity', $voucher->quantity ?? '') }}" required>
    </div>
</div>
