<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Status;
use App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('status')->withCount('products')->latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        $statuses = Status::where('type', 'brand')->get();
        return view('admin.brands.create', compact('statuses'));
    }

    public function store(BrandRequest $request)
    {
        $validated = $request->validated();
        // Set default status_id to active status for brand type
        $validated['status_id'] = Status::where('type', 'brand')->where('code', 'active')->value('id');
        Brand::create($validated);
        return redirect()->route('admin.brands.index')->with('success', 'Thêm nhãn hiệu thành công!');
    }

    public function edit(Brand $brand)
    {
        $statuses = Status::where('type', 'brand')->get();
        return view('admin.brands.edit', compact('brand','statuses'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $validated = $request->validated();
        if(empty($validated['status_id'])){
            $validated['status_id'] = Status::where('type','brand')->where('code','active')->value('id');
        }
        $brand->update($validated);
        return redirect()->route('admin.brands.index')->with('success', 'Cập nhật nhãn hiệu thành công!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Xóa nhãn hiệu thành công!');
    }
}