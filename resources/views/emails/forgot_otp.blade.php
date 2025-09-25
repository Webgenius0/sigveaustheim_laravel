@component('mail::message')
# Hello {{ $user->name ?? 'User' }}, 👋

We received a request to reset your password.
Here is your One-Time Password (OTP):

@component('mail::panel')
**{{ $otp }}**
@endcomponent

This OTP will expire in **5 minutes**.
Please use it immediately to reset your password.

If you didn’t request a password reset, you can safely ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
