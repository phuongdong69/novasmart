<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::orderBy('type')->orderBy('priority')->get();
        return view('admin.statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:statuses,code',
            'type' => 'required|string|max:50',
            'color' => 'required|string|max:7',
            'priority' => 'required|integer',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Status::create($request->all());

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status created successfully.');
    }

    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:statuses,code,' . $status->id,
            'type' => 'required|string|max:50',
            'color' => 'required|string|max:7',
            'priority' => 'required|integer',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $status->update($request->all());

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status updated successfully.');
    }

    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('admin.statuses.index')
            ->with('success', 'Status deleted successfully.');
    }
} 