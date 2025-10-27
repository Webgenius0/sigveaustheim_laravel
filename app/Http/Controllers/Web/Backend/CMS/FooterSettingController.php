<?php

namespace App\Http\Controllers\Web\Backend\CMS;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FooterSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FooterSettingController extends Controller
{
    public function index()
    {
        $setting = FooterSetting::firstOrCreate([]);
        return view('backend.layouts.cms.footer', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = FooterSetting::firstOrCreate([]);

        // Validation
        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string|max:1000',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,ico|max:2048',
            'help_center_pdf' => 'nullable|mimes:pdf|max:10240',
            'privacy_policy_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 't-error')
                ->withInput();
        }

        $data = [
            'description' => $request->description,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($setting->logo && file_exists(public_path($setting->logo))) {
                @unlink(public_path($setting->logo));
            }

            $data['logo'] = $this->uploadFile($request->file('logo'), 'footer/logo');
        }

        // Handle PDF uploads
        if ($request->hasFile('help_center_pdf')) {
            // Delete old PDF
            if ($setting->help_center_pdf && file_exists(public_path($setting->help_center_pdf))) {
                @unlink(public_path($setting->help_center_pdf));
            }

            $data['help_center_pdf'] = $this->uploadFile($request->file('help_center_pdf'), 'footer/pdfs');
        }

        if ($request->hasFile('privacy_policy_pdf')) {
            // Delete old PDF
            if ($setting->privacy_policy_pdf && file_exists(public_path($setting->privacy_policy_pdf))) {
                @unlink(public_path($setting->privacy_policy_pdf));
            }

            $data['privacy_policy_pdf'] = $this->uploadFile($request->file('privacy_policy_pdf'), 'footer/pdfs');
        }

        // Handle social icons
        $socialIcons = [];
        if ($request->has('social_icons') && is_array($request->social_icons)) {
            foreach ($request->social_icons as $index => $iconData) {
                $link = isset($iconData['link']) ? trim($iconData['link']) : '';
                $iconImagePath = null;

                // Get existing icon path
                $existingIcons = $setting->social_icons ?? [];
                if (isset($existingIcons[$index]['icon_image'])) {
                    $iconImagePath = $existingIcons[$index]['icon_image'];
                }

                // Handle new image upload
                if ($request->hasFile("social_icons.{$index}.icon_image")) {
                    // Delete old image
                    if ($iconImagePath && file_exists(public_path($iconImagePath))) {
                        @unlink(public_path($iconImagePath));
                    }

                    $iconImagePath = $this->uploadFile($request->file("social_icons.{$index}.icon_image"), 'footer/social-icons');
                }

                // Add to array if there's link or image
                if ($link || $iconImagePath) {
                    $socialIcons[] = [
                        'icon_image' => $iconImagePath,
                        'link' => $link,
                    ];
                }
            }
        }

        $data['social_icons'] = $socialIcons;

        // Update settings
        $setting->update($data);

        return redirect()->back()->with('t-success', 'Footer settings updated successfully!');
    }

    /**
     * Upload file to public directory
     */
    private function uploadFile($file, $directory)
    {
        // Create directory if it doesn't exist
        $uploadPath = public_path($directory);
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Move file to public directory
        $file->move($uploadPath, $fileName);

        // Return relative path
        return $directory . '/' . $fileName;
    }

    /**
     * Delete file from public directory
     */
    private function deleteFile($filePath)
    {
        if ($filePath && file_exists(public_path($filePath))) {
            @unlink(public_path($filePath));
            return true;
        }
        return false;
    }
}
