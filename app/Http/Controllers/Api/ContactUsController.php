<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Helper\Helper;
use App\Models\ContactUs;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Mail\ContactUsUserMail;
use App\Mail\ContactUsAdminMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    use ApiResponse;

    // store and mail contact function
    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'organization' => 'nullable|string|max:255',
            'subject'      => 'nullable|string|max:255',
            'message'      => 'nullable|string',
            'file'         => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $message = $errors[0] ?? 'Validation failed.';
            if (count($errors) > 1) {
                $message .= ' (and ' . (count($errors) - 1) . ' more errors)';
            }

            return $this->error([], $message, 422);
        }

        DB::beginTransaction();
        try {
            // Upload file if exists
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = Helper::fileUpload(
                    $request->file('file'),
                    'contact_us',
                    $request->name . '_' . time()
                );
            }

            // Save into DB
            $contact = ContactUs::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'organization' => $request->organization,
                'file_path'    => $filePath,
                'subject'      => $request->subject,
                'message'      => $request->message,
            ]);

            // Send mails
            Mail::to('arifulislam6460@gmail.com')->send(new ContactUsAdminMail($contact));
            Mail::to($contact->email)->send(new ContactUsUserMail($contact));

            DB::commit();

            return $this->success($contact, 'Contact message submitted successfully.', 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], 'Failed to submit message. ' . $e->getMessage(), 500);
        }
    }
}
