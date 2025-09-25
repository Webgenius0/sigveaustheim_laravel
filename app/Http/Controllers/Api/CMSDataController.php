<?php

namespace App\Http\Controllers\Api;

use App\Models\CMS;
use Illuminate\Http\Request;
use App\Http\Resources\CMSResource;
use App\Http\Controllers\Controller;

class CMSDataController extends Controller
{
    //get cms data by key
    public function getData(Request $request)
    {
        $data = CMS::all();

        $grouped = $data->groupBy('section')->map(function ($sectionItems) {
            return $sectionItems->groupBy('name')->map(function ($items) {
                return CMSResource::collection($items);
            });
        });

        return response()->json([
            'status' => 'success',
            'data'   => $grouped
        ], 200);
    }
}
