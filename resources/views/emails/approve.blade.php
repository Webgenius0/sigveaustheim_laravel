@extends('emails.layout.master')

@section('title', 'School Approved')

@section('content')

    <body style="margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; background-color:#f4f4f4;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:20px 0;">
            <tr>
                <td align="center">
                    <!-- Main Container -->
                    <table width="600" cellpadding="0" cellspacing="0" border="0" class="container"
                        style="max-width:600px; width:100%; background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow: 0 6px 18px rgba(0,0,0,0.06);">

                        <!-- Header -->
                        <tr>
                            <td align="center" style="padding:18px 16px; background-color:#ffffff;">
                                <img src="{{ $message->embed(public_path('default/logo.png')) }}"
                                    alt="{{ config('app.name') }} Logo"
                                    style="display:block; max-width:120px; height:auto;">
                            </td>
                        </tr>

                        <!-- Hero Section -->
                        <tr>
                            <td align="center" style="padding:24px 24px 8px 24px;" class="mobile-padding">
                                <h1 style="margin:0; font-size:22px; color:#2b2b2b; font-weight:700;">
                                    🎉 Congratulations {{ $teacher->name }},
                                </h1>
                                <p style="margin:12px 0 0; color:#666; font-size:15px; line-height:1.5; max-width:520px;">
                                    Your school <strong>{{ $school->name }}</strong> has been successfully approved by our
                                    admin team.
                                </p>
                            </td>
                        </tr>

                        <!-- Content Box -->
                        <tr>
                            <td align="center" style="padding:18px 24px 30px 24px;">
                                <table width="100%" cellpadding="18" cellspacing="0" border="0"
                                    style="background-color:#fbfbfb; border-radius:8px; text-align:left; border:1px solid #eee;">
                                    <tr>
                                        <td style="padding:10px 0 12px 10px;">
                                            <h2 style="margin:0 0 10px; color:#7a2048; font-size:18px;">School Details</h2>

                                            <table width="100%" cellpadding="6" cellspacing="0"
                                                style="margin-bottom:6px;">
                                                <tr>
                                                    <td width="34%" style="color:#555; padding:6px 0;"><strong>School
                                                            Name:</strong></td>
                                                    <td style="padding:6px 0;">{{ $school->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#555; padding:6px 0;"><strong>Principal:</strong></td>
                                                    <td style="padding:6px 0;">{{ $school->principal_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#555; padding:6px 0;"><strong>Registered
                                                            Email:</strong></td>
                                                    <td style="padding:6px 0;">{{ $school->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#555; padding:6px 0;"><strong>Approved At:</strong>
                                                    </td>
                                                    <td style="padding:6px 0;">
                                                        {{ optional($school->approved_at)->format('d M, Y h:i A') ?? '—' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding-top:18px; text-align:center;">
                                            <!-- Button -->
                                            <table cellspacing="0" cellpadding="0" style="display:inline-table;">
                                                <tr>
                                                    <td align="center">
                                                        <a href="{{ rtrim(config('app.frontend_url'), '/') . '/' }}"
                                                            style="background-color:#7a2048; color:#ffffff; padding:12px 30px; border:1px solid #7a2048; border-radius:6px; cursor:pointer; font-weight:bold; font-size:14px; text-decoration:none; display:inline-block;">
                                                            Go to Dashboard
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td
                                            style="padding-top:18px; color:#666; font-size:14px; line-height:1.5; text-align:center;">
                                            You can now access the dashboard and start managing your account.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- Support Note -->
                        <tr>
                            <td align="center" style="padding:0 24px 18px 24px;">
                                <p style="margin:0; color:#666; font-size:13px;">
                                    If you have any questions, feel free to contact our support team.
                                </p>
                            </td>
                        </tr>

                        <!-- Footer inside container -->
                        <tr>
                            <td align="center" style="padding:18px; background-color:#f9f9f9; font-size:12px; color:#888;">
                                <p style="margin:0;">Thanks,<br><strong>{{ config('app.name') }}</strong></p>
                                <p style="margin:8px 0 0; font-size:11px; color:#999;">This is an automated message. Please
                                    do not reply to this email.</p>
                            </td>
                        </tr>
                    </table>

                    <!-- Outer Legal Footer -->
                    <table width="600" cellpadding="0" cellspacing="0" border="0"
                        style="max-width:600px; width:100%; margin-top:12px;">
                        <tr>
                            <td align="center" style="font-size:11px; color:#999;">
                                <p style="margin:0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights
                                    reserved.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
@endsection
