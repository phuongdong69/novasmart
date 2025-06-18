<div class="variant-item border p-3 mb-3 rounded bg-light">
  <div class="mb-2">
    <label>SKU</label>
    <input type="text" name="variants[{{ $i }}][sku]" value="{{ old('variants.' . $i . '.sku') ?? ($variant->sku ?? '') }}" class="form-control">
  </div>

  <div class="mb-2">
    <label>Giá</label>
    <input type="number" name="variants[{{ $i }}][price]" value="{{ old('variants.' . $i . '.price') ?? ($variant->price ?? '') }}" class="form-control">
  </div>

  <div class="mb-2">
    <label>Số lượng</label>
    <input type="number" name="variants[{{ $i }}][quantity]" value="{{ old('variants.' . $i . '.quantity') ?? ($variant->quantity ?? '') }}" class="form-control">
  </div>

  <h6>Thuộc tính biến thể</h6>
 
</div>
