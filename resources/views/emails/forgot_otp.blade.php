@extends('emails.layout.master')

@section('title', 'Forgot Password')

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
                                    Hello {{ $user->name ?? 'User' }}, 👋
                                </h1>

                                <p style="margin:0 0 20px; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    We received a request to reset your password.<br>
                                    Here is your One-Time Password (OTP):
                                </p>

                                <!-- OTP Panel (like mail::panel) -->
                                <table width="100%" cellpadding="20" cellspacing="0" border="0"
                                    style="background-color:#f9f9f9; border-radius:8px; text-align:center; border:1px solid #eee; margin:20px 0;">
                                    <tr>
                                        <td>
                                            <span style="font-size:28px; font-weight:bold; letter-spacing:4px; color:#333;">
                                                {{ $otp }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin:20px 0 0; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    This OTP will expire in <strong>5 minutes</strong>.<br>
                                    Please use it immediately to reset your password.
                                </p>

                                <p style="margin:20px 0 0; color:#666; font-size:16px; line-height:1.5; text-align:left;">
                                    If you didn’t request a password reset, you can safely ignore this email.
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
