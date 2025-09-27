@extends('emails.layout.master')

@section('title', 'School Status Pending')

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
                                    ⏳ Renewal Required - {{ $school->name }}
                                </h1>

                                <p style="margin:0 0 20px; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    Dear <strong>{{ $teacher->name }}</strong>,
                                </p>

                                <p style="margin:0 0 20px; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    Your school <strong>{{ $school->name }}</strong> has been set to
                                    <span style="color:#eab308; font-weight:bold;">Pending</span> status.<br>
                                    This means your current subscription has expired, and renewal is required to continue
                                    using our services.
                                </p>

                                <hr style="border:0; border-top:1px solid #eee; margin:25px 0;">

                                <h2 style="margin:0 0 15px; color:#7a2048; font-size:20px; text-align:left;">School Details
                                </h2>

                                <table width="100%" cellpadding="8" cellspacing="0" style="margin-bottom:25px;">
                                    <tr>
                                        <td width="35%" style="color:#555; padding:6px 0;"><strong>School Name:</strong>
                                        </td>
                                        <td style="padding:6px 0;">{{ $school->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#555; padding:6px 0;"><strong>Principal:</strong></td>
                                        <td style="padding:6px 0;">{{ $school->principal_name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#555; padding:6px 0;"><strong>Registered Email:</strong></td>
                                        <td style="padding:6px 0;">{{ $school->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#555; padding:6px 0;"><strong>Status Changed At:</strong></td>
                                        <td style="padding:6px 0;">{{ now()->format('d M, Y h:i A') }}</td>
                                    </tr>
                                </table>

                                <p style="margin:0 0 25px; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    Without renewal, your school’s access to the platform (including event management,
                                    communication tools, and resources)
                                    will remain <strong style="color:#dc2626;">inactive</strong>.
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
                                                            Contact For Renew
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin:25px 0 0; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    If you need assistance with the renewal process, please reach out to our support team at
                                    <a href="mailto:{{ config('mail.from.address') }}"
                                        style="color:#7a2048; text-decoration:underline;">{{ config('mail.from.address') }}</a>.
                                </p>

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
