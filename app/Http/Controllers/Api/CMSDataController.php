<?php

namespace App\Http\Controllers\Api;

use App\Models\CMS;
use Illuminate\Http\Request;
use App\Http\Resources\CMSResource;
use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use App\Models\TestGuide;
use App\Models\TestRecordSheet;

class CMSDataController extends Controller
{
    //get cms data by key
    public function getData()
    {
        // CMS Data
        $data = CMS::all();
        $testGuide = TestGuide::first();
        $recordSheets = TestRecordSheet::select('id', 'name', 'sheet_url')->get();

        $grouped = $data->groupBy('section')->map(function ($sectionItems) {
            return $sectionItems->groupBy('name')->map(function ($items) {
                return CMSResource::collection($items);
            });
        });

        // Footer Data
        $footerSetting = FooterSetting::first();

        $footer = null;
        if ($footerSetting) {
            $footer = [
                'logo' => $footerSetting->logo ? asset($footerSetting->logo) : null,
                'description' => $footerSetting->description,
                'email' => $footerSetting->email,
                'phone' => $footerSetting->phone,
                'terms_&_condition' => $footerSetting->help_center_pdf ? asset($footerSetting->help_center_pdf) : null,
                'privacy_policy_pdf' => $footerSetting->privacy_policy_pdf ? asset($footerSetting->privacy_policy_pdf) : null,
                'social_icons' => collect($footerSetting->social_icons ?? [])->map(function ($icon) {
                    return [
                        'icon_image' => isset($icon['icon_image']) ? asset($icon['icon_image']) : null,
                        'link' => $icon['link'] ?? null,
                    ];
                })->values()->all(),
            ];
        }

        // Add Test Guide PDF link
        $testGuideData = null;
        if ($testGuide) {
            $testGuideData = [
                'name' => $testGuide->name,
                'guide_file_url' => $testGuide->guide_file_path ? asset($testGuide->guide_file_path) : null,
            ];
        }

        // Add multiple test sheet pdf links
        $testSheetData = $recordSheets->map(function ($sheet) {
            return [
                'id' => $sheet->id,
                'name' => $sheet->name,
                'sheet_url' => $sheet->sheet_url ? asset($sheet->sheet_url) : null,
            ];
        })->values()->all();

        return response()->json([
            'status' => 'success',
            'data' => array_merge(
                $grouped->toArray(),
                [
                    'footer' => $footer,
                    'test_guide' => $testGuideData,
                    'test_sheets' => $testSheetData,
                ]
            ),
        ], 200);
    }
}
