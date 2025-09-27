@extends('emails.layout.master')

@section('title', 'School Registration Cancelled')

@section('content')

    <body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background-color:#f4f4f4;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:20px 0;">
            <tr>
                <td align="center">
                    <!-- Container -->
                    <table width="600" cellpadding="0" cellspacing="0" border="0" class="container"
                        style="max-width:100%; background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <!-- Header -->
                        <tr>
                            <td align="center" style="padding:5px; background-color:#f9f9f9;">
                                <img src="{{ $message->embed(public_path('default/logo.png')) }}" alt="Logo"
                                    style="display:block; max-width:100px; height:auto;">
                            </td>
                        </tr>

                        <!-- Content -->
                        <tr>
                            <td align="center" style="padding:30px 25px;" class="mobile-padding">
                                <h1 style="margin:0 0 20px; color:#333; font-size:24px; text-align:center;">❌ School
                                    Registration Cancelled</h1>

                                <p style="margin:0 0 20px; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    Dear <strong>{{ $teacher->name }}</strong>,
                                </p>

                                <p style="margin:0 0 20px; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    We regret to inform you that your school registration request for
                                    <strong>{{ $school->name }}</strong> has been
                                    <span style="color:#dc2626; font-weight:bold;">cancelled</span> by our admin team.
                                </p>

                                <table width="100%" cellpadding="15" cellspacing="0" border="0"
                                    style="background-color:#f9f9f9; border-radius:8px; text-align:left; border:1px solid #eee; margin-bottom:25px;">
                                    <tr>
                                        <td>
                                            <p style="margin:8px 0; color:#555;"><strong>School Name:</strong>
                                                {{ $school->name }}</p>
                                            <p style="margin:8px 0; color:#555;"><strong>Principal:</strong>
                                                {{ $school->principal_name }}</p>
                                            <p style="margin:8px 0; color:#555;"><strong>Registered Email:</strong>
                                                {{ $school->email }}</p>
                                            <p style="margin:8px 0; color:#555;"><strong>Cancelled At:</strong>
                                                {{ optional($school->cancelled_at)->format('d M, Y h:i A') }}</p>
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin:0 0 20px; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    If you believe this is a mistake or need clarification,
                                    please contact our support team at
                                    <strong>{{ config('mail.from.address') }}</strong>.
                                </p>

                                <!-- Button -->
                                <table width="100%" cellspacing="0" cellpadding="0" class="button-container">
                                    <tr>
                                        <td align="center">
                                            <table cellspacing="0" cellpadding="0" style="display:inline-table;">
                                                <tr>
                                                    <td align="center">
                                                        <a href="{{ config('app.frontend_url') . '/contact' }}"
                                                            style="background-color:#7a2048; color:#ffffff; padding:12px 30px; border:1px solid #7a2048; border-radius:5px; cursor:pointer; font-weight:bold; font-size:14px; text-decoration:none; display:inline-block;">
                                                            Contact Support
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
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
