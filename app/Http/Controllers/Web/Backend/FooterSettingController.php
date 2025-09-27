<?php

namespace App\Http\Controllers\Web\Backend;

use Illuminate\Http\Request;
use App\Models\FooterSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FooterSettingController extends Controller
{
    // index footer
    public function index()
    {
        $setting = FooterSetting::firstOrCreate([]);
        return view('backend.layouts.cms.footer', compact('setting'));
    }

    // update footer date
    public function update(Request $request)
    {
        $setting = FooterSetting::first();

        $validated = $request->validate([
            'description' => 'nullable|string|max:500',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'help_center_pdf' => 'nullable|mimes:pdf|max:10240',
            'privacy_policy_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);

        // Logo Upload
        if ($request->hasFile('logo')) {
            if ($setting->logo && Storage::exists($setting->logo)) {
                Storage::delete($setting->logo);
            }
            $validated['logo'] = $request->file('logo')->store('footer/logo', 'public');
        }

        // Help Center PDF Upload
        if ($request->hasFile('help_center_pdf')) {
            if ($setting->help_center_pdf && Storage::exists($setting->help_center_pdf)) {
                Storage::delete($setting->help_center_pdf);
            }
            $validated['help_center_pdf'] = $request->file('help_center_pdf')->store('footer/pdfs', 'public');
        }

        // Privacy Policy PDF Upload
        if ($request->hasFile('privacy_policy_pdf')) {
            if ($setting->privacy_policy_pdf && Storage::exists($setting->privacy_policy_pdf)) {
                Storage::delete($setting->privacy_policy_pdf);
            }
            $validated['privacy_policy_pdf'] = $request->file('privacy_policy_pdf')->store('footer/pdfs', 'public');
        }

        // Social Icons (JSON)
        $socialIcons = [];
        if ($request->filled('social_icon')) {
            foreach ($request->input('social_icon') as $index => $icon) {
                if (!empty($icon['icon']) && !empty($icon['link'])) {
                    $socialIcons[] = [
                        'icon' => $icon['icon'],
                        'link' => $icon['link']
                    ];
                }
            }
        }
        $validated['social_icons'] = $socialIcons;

        $setting->update($validated);

        return redirect()->back()->with('success', 'Footer settings updated successfully!');
    }
}
