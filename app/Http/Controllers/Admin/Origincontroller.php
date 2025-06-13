<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\OriginRequest;
use App\Http\Controllers\Controller;
use App\Models\Origin;
use Illuminate\Http\Request;

class Origincontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $origins = Origin::orderBy('id', )->paginate(10);
        return view('admin.origins.index', compact('origins'));
    }

    public function create()
    {
        return view('admin.origins.create');
    }

    public function store(OriginRequest $request)
    {

        try {
            Origin::create($request->validated());

            return redirect()->route('admin.origins.index')->with('success', 'Thêm nguồn gốc thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.origins.index')->with('error', 'Không thêm nguồn gốc thành công.');
        }
    }

    public function edit($id)
    {
        $origin = Origin::findOrFail($id);
        return view('admin.origins.edit', compact('origin'));
    }

    public function update(OriginRequest $request, $id)
    {

        try {
            $origin = Origin::findOrFail($id);

            Origin::create($request->validated());

            return redirect()->route('admin.origins.index')->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.origins.index')->with('error', 'Cập nhật không thành công.');
        }
    }
    public function destroy($id)
    {
        try {
            $origin = Origin::findOrFail($id);
            $origin->delete();

            return redirect()->route('admin.origins.index')->with('success', 'Đã xoá thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.origins.index')->with('error', 'Đã xoá không thành công.');
        }
    }
}
