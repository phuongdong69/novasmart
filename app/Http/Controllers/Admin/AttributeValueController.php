<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Attribute;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $values = AttributeValue::with('attribute')->latest()->paginate(10);
        return view('admin.attribute_values.index', compact('values'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributes = Attribute::all();
        return view('admin.attribute_values.create', compact('attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeValueRequest $request)
    {
        AttributeValue::create($request->validated());
        return redirect()->route('admin.attribute_values.index')->with('success', 'Thêm giá trị thuộc tính thành công.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();
        return view('admin.attribute_values.edit', compact('attributeValue', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $attributeValue->update($request->only('value'));
                return response()->json(['success' => true, 'value' => $attributeValue->value]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật giá trị!'], 422);
            }
        }
        $attributeValue->update($request->validated());
        return redirect()->route('admin.attribute_values.index')->with('success', 'Cập nhật giá trị thuộc tính thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return redirect()->route('admin.attribute_values.index')->with('success', 'Xóa giá trị thuộc tính thành công.');
    }
}
