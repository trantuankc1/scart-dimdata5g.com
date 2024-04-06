<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Models\Agency;
use App\Models\AgencyRelation;
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
            'name' => 'required|string|max:100',
        ]);

        // Tạo đại lý mới và gán UUID cho cột 'id'
        $agency = new Agency();
        $agency->id = Str::uuid();
        $agency->name = $validatedData['name'];
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