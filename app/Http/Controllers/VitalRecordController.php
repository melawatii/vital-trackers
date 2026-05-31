<?php

namespace App\Http\Controllers;

use App\Models\VitalRecord;
use App\Models\VitalCategory;
use App\Models\VitalType;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVitalRecordRequest;
use App\Http\Requests\UpdateVitalRecordRequest;

class VitalRecordController extends Controller
{
    /** Display list of records */
    public function index()
    {
        $records = VitalRecord::with(['user','category','type'])->get();
        return view('vital-records.index', compact('records'));
    }

    /** Show create form */
    public function create()
    {
        $users = User::all();
        $categories = VitalCategory::active()->get();
        $types = VitalType::active()->get();
        return view('vital-records.create', compact('users','categories','types'));
    }

    /** Store new record */
    public function store(StoreVitalRecordRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        VitalRecord::create($data);
        return redirect()->route('vital-records.index')->with('success','Vital record created successfully.');
    }

    /** Show edit form */
    public function edit(VitalRecord $vitalRecord)
    {
        $users = User::all();
        $categories = VitalCategory::active()->get();
        $types = VitalType::active()->get();
        return view('vital-records.edit', compact('vitalRecord','users','categories','types'));
    }

    /** Update record */
    public function update(UpdateVitalRecordRequest $request, VitalRecord $vitalRecord)
    {
        $data = $request->validated();
        $vitalRecord->update($data);
        return redirect()->route('vital-records.index')->with('success','Vital record updated successfully.');
    }

    /** Delete record */
    public function destroy(VitalRecord $vitalRecord)
    {
        $vitalRecord->delete();
        return redirect()->route('vital-records.index')->with('success','Vital record deleted successfully.');
    }
}
