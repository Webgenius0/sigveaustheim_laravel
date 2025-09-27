<?php

namespace App\Http\Controllers\Api;

use App\Models\CMS;
use Illuminate\Http\Request;
use App\Http\Resources\CMSResource;
use App\Http\Controllers\Controller;
use App\Models\FooterSetting;

class CMSDataController extends Controller
{
    //get cms data by key
    public function getData(Request $request)
    {
        // CMS Data (grouped)
        $data = CMS::all();
        $grouped = $data->groupBy('section')->map(function ($sectionItems) {
            return $sectionItems->groupBy('name')->map(function ($items) {
                return CMSResource::collection($items);
            });
        });

        // Footer Data
        $footerSetting = FooterSetting::first(); // Only one row expected

        // Format footer data (with asset paths)
        $footer = null;
        if ($footerSetting) {
            $footer = [
                'logo' => $footerSetting->logo ? asset($footerSetting->logo) : null,
                'description' => $footerSetting->description,
                'email' => $footerSetting->email,
                'phone' => $footerSetting->phone,
                'help_center_pdf' => $footerSetting->help_center_pdf ? asset($footerSetting->help_center_pdf) : null,
                'privacy_policy_pdf' => $footerSetting->privacy_policy_pdf ? asset($footerSetting->privacy_policy_pdf) : null,
                'social_icons' => collect($footerSetting->social_icons ?? [])->map(function ($icon) {
                    return [
                        'icon_image' => $icon['icon_image'] ?? null ? asset($icon['icon_image']) : null,
                        'link' => $icon['link'] ?? null,
                    ];
                })->values()->all(),
            ];
        }

        return response()->json([
            'status' => 'success',
            'data'   => $grouped,
            'footer' => $footer,
        ], 200);
    }
}
