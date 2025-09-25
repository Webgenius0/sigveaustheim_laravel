@component('mail::message')
# 👋 Hello {{ $contact->name }},

Thank you for reaching out to us!
We’ve received your message and our team will get back to you soon.

**Your submitted details:**

- **Subject:** {{ $contact->subject ?? 'N/A' }}
- **Message:**
{{ $contact->message }}

---

@component('mail::button', ['url' => config('app.url')])
Visit Our Website
@endcomponent

We appreciate your time.
**– The {{ config('app.name') }} Team**
@endcomponent
