<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agencies = Agency::all();

        return view('agencies.index', compact('agencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'level' => 'required|integer|min:1', // Kiểm tra level là số nguyên dương
        ]);
        $uuid = Str::uuid();
        $agency = new Agency();
        $agency->id = $uuid;
        $agency->name = $request->input('name');
        $agency->level = $request->input('level');
        $agency->save();

        return redirect()->route('agency.index')->with('success', 'Đã tạo đại lý thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agency = Agency::findOrFail($id);
        return view('agencies.edit', compact('agency'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $agency = Agency::findOrFail($id);
        $agency->update($request->all());
        return redirect()->route('agency.index', $id)->with('success', 'Đã cập nhật thông tin đại lý!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $agency = Agency::findOrFail($id);
        $agency->delete();
        return redirect()->route('agency.index')->with('success', 'Đã xóa đại lý!');
    }
}
