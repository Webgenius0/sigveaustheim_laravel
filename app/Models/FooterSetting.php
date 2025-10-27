<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'description',
        'social_icons',
        'help_center_pdf',
        'privacy_policy_pdf',
        'email',
        'phone'
    ];

    protected $casts = [
        'social_icons' => 'array',
    ];

    // Add this method to debug social icons saving
    public function setSocialIconsAttribute($value)
    {
        // Debug what we're trying to save
        Log::info('Saving social icons:', ['data' => $value]);
        $this->attributes['social_icons'] = json_encode($value);
    }

    // Accessor for logo URL
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('/' . $this->logo) : null;
    }

    // Accessor for help center PDF URL
    public function getHelpCenterPdfUrlAttribute()
    {
        return $this->help_center_pdf ? asset('/' . $this->help_center_pdf) : null;
    }

    // Accessor for privacy policy PDF URL
    public function getPrivacyPolicyPdfUrlAttribute()
    {
        return $this->privacy_policy_pdf ? asset('/' . $this->privacy_policy_pdf) : null;
    }

    // Get social icons with full URLs
    public function getSocialIconsWithUrlsAttribute()
    {
        if (!$this->social_icons) {
            return [];
        }

        return collect($this->social_icons)->map(function ($icon) {
            return [
                'icon_image' => $icon['icon_image'] ? asset('/' . $icon['icon_image']) : null,
                'link' => $icon['link'] ?? null,
            ];
        })->toArray();
    }

    // Check if footer has social icons
    public function hasSocialIcons()
    {
        return !empty($this->social_icons) && count($this->social_icons) > 0;
    }

    // Get active social icons (with both image and link)
    public function getActiveSocialIcons()
    {
        if (!$this->social_icons) {
            return [];
        }

        return collect($this->social_icons)->filter(function ($icon) {
            return !empty($icon['icon_image']) && !empty($icon['link']);
        })->toArray();
    }
}
