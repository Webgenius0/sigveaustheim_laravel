<?php

namespace App\Http\Controllers;

use App\Models\FitnessTests;
use Illuminate\Http\Request;
use App\Models\TestRecordSheet;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TestRecordSheetController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sheets = TestRecordSheet::with('fitnessTest:id,name')->latest('id')->get();

            return datatables()->of($sheets)
                ->addIndexColumn()
                ->addColumn('fitness_test', fn($row) => $row->fitnessTest->name ?? '---')
                ->addColumn('name', fn($row) => $row->name ?? '---')
                ->addColumn(
                    'sheet_url',
                    fn($row) => $row->sheet_url
                        ? '<a href="' . asset($row->sheet_url) . '" target="_blank">View Sheet</a>'
                        : '---'
                )
                ->addColumn('action', function ($row) {
                    $viewBtn = $row->sheet_url ? '<a href="' . asset($row->sheet_url) . '" target="_blank" class="btn btn-info btn-sm"><i class="fe fe-eye"></i></a>' : '';
                    return '<div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-primary btn-sm editSheet" data-id="' . $row->id . '"><i class="fe fe-edit"></i></button>
                        <button type="button" onclick="showDeleteConfirm(' . $row->id . ')" class="btn btn-danger btn-sm"><i class="fe fe-trash"></i></button>
                        ' . $viewBtn . '
                    </div>';
                })
                ->rawColumns(['sheet_url', 'action'])
                ->make(true);
        }

        $fitnessTests = FitnessTests::select('id', 'name')->get();
        return view('backend.layouts.tests.test_sheet', compact('fitnessTests'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fitness_test_id' => 'required|exists:fitness_tests,id|unique:test_record_sheets,fitness_test_id',
            'name' => 'required|string|max:255',
            'sheet_url' => 'required|file|mimes:pdf,xlsx,xls,jpg,jpeg,png|max:5120', // 5MB max
        ], [
            'fitness_test_id.unique' => 'A sheet for this fitness test already exists.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }

        // Upload file
        $path = $request->file('sheet_url')->store('uploads/test_sheets', 'public');

        TestRecordSheet::create([
            'fitness_test_id' => $request->fitness_test_id,
            'name' => $request->name,
            'sheet_url' => 'storage/' . $path,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Test record sheet uploaded successfully!',
        ]);
    }

    public function edit($id)
    {
        $sheet = TestRecordSheet::find($id);
        if (!$sheet) {
            return response()->json(['success' => false, 'message' => 'Sheet not found']);
        }

        return response()->json(['success' => true, 'data' => $sheet]);
    }

    public function update(Request $request, $id)
    {
        $sheet = TestRecordSheet::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fitness_test_id' => 'required|exists:fitness_tests,id|unique:test_record_sheets,fitness_test_id,' . $id,
            'name' => 'required|string|max:255',
            'sheet_url' => 'nullable|file|mimes:pdf,xlsx,xls,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }

        if ($request->hasFile('sheet_url')) {
            if ($sheet->sheet_url && file_exists(public_path($sheet->sheet_url))) {
                unlink(public_path($sheet->sheet_url));
            }
            $path = $request->file('sheet_url')->store('uploads/test_sheets', 'public');
            $sheet->sheet_url = 'storage/' . $path;
        }

        $sheet->update([
            'fitness_test_id' => $request->fitness_test_id,
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Sheet updated successfully!',
        ]);
    }

    public function destroy($id)
    {
        $sheet = TestRecordSheet::findOrFail($id);
        if ($sheet->sheet_url && file_exists(public_path($sheet->sheet_url))) {
            unlink(public_path($sheet->sheet_url));
        }
        $sheet->delete();

        return response()->json(['status' => 1, 'message' => 'Sheet deleted successfully!']);
    }
}
