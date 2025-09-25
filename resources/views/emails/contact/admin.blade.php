@component('mail::message')
# 📩 New Contact Form Submission

**Name:** {{ $contact->name }}
**Email:** {{ $contact->email }}
**Organization:** {{ $contact->organization ?? 'N/A' }}
**Subject:** {{ $contact->subject ?? 'N/A' }}

---

**Message:**
{{ $contact->message }}

@if($contact->file_path)
📎 Attachment uploaded at: {{ url($contact->file_path) }}
@endif

@component('mail::panel')
This message was sent from your Contact Us form.
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent
