@extends('emails.layout.master')

@section('title', 'New Contact Support Request')

@section('content')

    <body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background-color:#f4f4f4;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:20px 0;">
            <tr>
                <td align="center">
                    <!-- Container -->
                    <table width="600" cellpadding="0" cellspacing="0" border="0" class="container"
                        style="max-width:600px; width:100%; background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

                        <!-- Header -->
                        <tr>
                            <td align="center" style="padding:5px; background-color:#f9f9f9;">
                                <img src="{{ $message->embed(public_path('default/logo.png')) }}"
                                    alt="{{ config('app.name') }} Logo"
                                    style="display:block; max-width:100px; height:auto;">
                            </td>
                        </tr>

                        <!-- Content -->
                        <tr>
                            <td align="center" style="padding:30px 25px;" class="mobile-padding">
                                <h1 style="margin:0 0 20px; color:#333; font-size:24px; text-align:center;">
                                    📩 New Contact Form Submission
                                </h1>

                                <table width="100%" cellpadding="8" cellspacing="0"
                                    style="margin-bottom:25px; text-align:left;">
                                    <tr>
                                        <td width="25%" style="color:#555; padding:6px 0;"><strong>Name:</strong></td>
                                        <td style="padding:6px 0;">{{ $contact->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#555; padding:6px 0;"><strong>Email:</strong></td>
                                        <td style="padding:6px 0;">{{ $contact->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#555; padding:6px 0;"><strong>Organization:</strong></td>
                                        <td style="padding:6px 0;">{{ $contact->organization ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#555; padding:6px 0;"><strong>Subject:</strong></td>
                                        <td style="padding:6px 0;">{{ $contact->subject ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                                <hr style="border:0; border-top:1px solid #eee; margin:25px 0;">

                                <h2 style="margin:0 0 15px; color:#7a2048; font-size:20px; text-align:left;">Message</h2>
                                <p
                                    style="margin:0; color:#555; font-size:16px; line-height:1.5; white-space:pre-wrap; text-align:left;">
                                    {{ $contact->message }}
                                </p>

                                @if ($contact->file_path)
                                    <p style="margin:20px 0 0; color:#666; font-size:15px; text-align:left;">
                                        📎 <strong>Attachment uploaded at:</strong><br>
                                        <a href="{{ url($contact->file_path) }}" target="_blank"
                                            style="color:#7a2048; text-decoration:underline;">
                                            {{ url($contact->file_path) }}
                                        </a>
                                    </p>
                                @endif

                                <!-- mail::panel equivalent -->
                                <table width="100%" cellpadding="18" cellspacing="0" border="0"
                                    style="background-color:#f9f9f9; border-radius:8px; margin-top:25px; border:1px solid #eee;">
                                    <tr>
                                        <td style="color:#666; font-size:14px; text-align:center;">
                                            This message was sent from your Contact Us form.
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin-top:25px; color:#666; font-size:16px; text-align:left;">
                                    Thanks,<br>
                                    <strong>{{ config('app.name') }}</strong>
                                </p>
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td align="center" style="padding:20px; font-size:12px; color:#888; background-color:#f9f9f9;">
                                <p style="margin:0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights
                                    reserved.</p>
                                <p style="margin:5px 0 0; font-size:11px; color:#999;">This is an automated message. Please
                                    do not reply to this email.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
@endsection
