<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantAttributeValue;
use App\Http\Requests\StoreVariantAttributeValueRequest;
use App\Http\Requests\UpdateVariantAttributeValueRequest;
use Illuminate\Http\Request;

class VariantAttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variantAttributeValues = VariantAttributeValue::with(['productVariant', 'attributeValue'])
            ->latest()
            ->paginate(10);
        
        return view('admin.variant_attribute_values.index', compact('variantAttributeValues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.variant_attribute_values.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVariantAttributeValueRequest $request)
    {
        $variantAttributeValue = VariantAttributeValue::create($request->validated());

        return redirect()->route('admin.variant_attribute_values.index')
            ->with('success', 'Giá trị thuộc tính biến thể đã được tạo thành công!');
    }

    /**
     * Hiển thị chi tiết giá trị thuộc tính biến thể
     */
    public function show(VariantAttributeValue $variantAttributeValue)
    {
        return view('admin.variant_attribute_values.show', compact('variantAttributeValue'));
    }

    /**
     * Hiển thị form chỉnh sửa giá trị thuộc tính biến thể
     */
    public function edit(VariantAttributeValue $variantAttributeValue)
    {
        return view('admin.variant_attribute_values.edit', compact('variantAttributeValue'));
    }

    /**
     * Cập nhật giá trị thuộc tính biến thể
     */
    public function update(UpdateVariantAttributeValueRequest $request, VariantAttributeValue $variantAttributeValue)
    {
        $variantAttributeValue->update($request->validated());

        return redirect()->route('admin.variant_attribute_values.index')
            ->with('success', 'Giá trị thuộc tính biến thể đã được cập nhật thành công!');
    }

    /**
     * Xóa giá trị thuộc tính biến thể
     */
    public function destroy(VariantAttributeValue $variantAttributeValue)
    {
        $variantAttributeValue->delete();

        return redirect()->route('admin.variant_attribute_values.index')
            ->with('success', 'Giá trị thuộc tính biến thể đã được xóa thành công!');
    }
}