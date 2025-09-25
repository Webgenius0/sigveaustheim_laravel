<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\ContactUs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
{
    //show contact us list
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::latest('id')->get();

            return DataTables::of($data)
                ->addIndexColumn()

                // Name column
                ->addColumn('name', function ($data) {
                    return $data->name ?? 'N/A';
                })

                // Email column
                ->addColumn('email', function ($data) {
                    return $data->email ?? 'N/A';
                })

                // Organization column
                ->addColumn('organization', function ($data) {
                    return $data->organization ?? 'N/A';
                })

                // Subject column
                ->addColumn('subject', function ($data) {
                    return $data->subject ?? 'N/A';
                })

                // Message column
                ->addColumn('message', function ($data) {
                    return Str::limit($data->message, 50); // short preview
                })

                // File column (clickable link)
                ->addColumn('file', function ($data) {
                    if ($data->file_path) {
                        $url = asset($data->file_path);
                        return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-primary">
                                View File
                            </a>';
                    }
                    return '<span class="badge bg-secondary">No File</span>';
                })

                ->rawColumns(['file'])
                ->make(true);
        }

        return view('backend.layouts.contact_us.index');
    }
}
