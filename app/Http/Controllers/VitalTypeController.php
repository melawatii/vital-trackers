<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\VitalType;
use App\Models\VitalCategory;

/**
 * CRUD controller for Vital Types
 */
class VitalTypeController extends Controller
{
    /**
     * Display listing.
     */
    public function index()
    {
        $types = VitalType::latest()->get();

        return view('vital-types.index', compact('types'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $categories = VitalCategory::active()->get();
        return view('vital-types.create', compact('categories'));
    }

    /**
     * Store new type.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'name' => 'required|max:100',
            'unit' => 'required|max:20',
            'input_type' => 'required',
            'normal_min' => 'nullable|numeric',
            'normal_max' => 'nullable|numeric',
            'danger_max' => 'nullable|numeric',
        ]);

        VitalType::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'unit' => $validated['unit'],
            'input_type' => $validated['input_type'],
            'normal_min' => $validated['normal_min'],
            'normal_max' => $validated['normal_max'],
            'danger_max' => $validated['danger_max'],
            'is_active' => true,
        ]);

        return redirect()->route('vital-types.index')->with('success', 'Vital type created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $type = VitalType::findOrFail($id);
        $categories = VitalCategory::active()->get();

        return view('vital-types.edit', compact('type','categories'));
    }

    /**
     * Update type.
     */
    public function update(Request $request, $id)
    {
        $type = VitalType::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required',
            'name' => 'required|max:100',
            'unit' => 'required|max:20',
            'input_type' => 'required',
            'normal_min' => 'nullable|numeric',
            'normal_max' => 'nullable|numeric',
            'danger_max' => 'nullable|numeric',
        ]);

        $type->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'unit' => $validated['unit'],
            'input_type' => $validated['input_type'],
            'normal_min' => $validated['normal_min'],
            'normal_max' => $validated['normal_max'],
            'danger_max' => $validated['danger_max'],
        ]);

        return redirect()->route('vital-types.index')->with('success', 'Vital type updated successfully.');
    }

    /**
     * Delete type.
     */
    public function destroy($id)
    {
        $type = VitalType::findOrFail($id);
        $type->delete();

        return redirect()->route('vital-types.index')->with('success', 'Vital type deleted successfully.');
    }
}
