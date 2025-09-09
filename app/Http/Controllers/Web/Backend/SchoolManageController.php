<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SchoolManageController extends Controller
{
    // public function approve(Request $request)
    // {
    //     $request->validate([
    //         'approval_token' => 'required|string|exists:schools,approval_token',
    //     ]);

    //     $school = School::where('approval_token', $request->approval_token)->firstOrFail();

    //     // If already approved/cancelled
    //     if ($school->status !== 'pending') {
    //         return response()->json([
    //             'message' => 'This school has already been ' . $school->status,
    //         ], 400);
    //     }

    //     DB::transaction(function () use ($school) {
    //         $school->update([
    //             'status' => 'approved',
    //             'approved_by' => Auth::id(),
    //             'approved_at' => now(),
    //             'approval_token' => null, // burn the token after use
    //         ]);
    //     });

    //     return response()->json([
    //         'message' => 'School approved successfully.',
    //         'school' => $school,
    //     ], 200);
    // }

    // public function cancel(Request $request)
    // {
    //     $request->validate([
    //         'approval_token' => 'required|string|exists:schools,approval_token',
    //     ]);

    //     $school = School::where('approval_token', $request->approval_token)->firstOrFail();

    //     if ($school->status !== 'pending') {
    //         return response()->json([
    //             'message' => 'This school has already been ' . $school->status,
    //         ], 400);
    //     }

    //     DB::transaction(function () use ($school) {
    //         $school->update([
    //             'status' => 'cancelled',
    //             'cancelled_by' => Auth::id(),
    //             'cancelled_at' => now(),
    //             'approval_token' => null, // burn the token after use
    //         ]);
    //     });

    //     return response()->json([
    //         'message' => 'School cancelled successfully.',
    //         'school' => $school,
    //     ], 200);
    // }


    public function approveFromEmail($token)
    {
        $school = School::where('approval_token', $token)->firstOrFail();

        if ($school->status !== 'pending') {
            return response()->json(['message' => 'This school is already ' . $school->status], 400);
        }

        // Ensure only logged-in admin can approve
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'You must login as admin to approve.');
        }

        $school->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_token' => null
        ]);

        return redirect()->route('dashboard')->with('success', 'School approved successfully.');
    }

    public function cancelFromEmail($token)
    {
        $school = School::where('approval_token', $token)->firstOrFail();

        if ($school->status !== 'pending') {
            return response()->json(['message' => 'This school is already ' . $school->status], 400);
        }

        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'You must login as admin to cancel.');
        }

        $school->update([
            'status' => 'cancelled',
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
            'approval_token' => null
        ]);

        return redirect()->route('dashboard')->with('success', 'School cancelled successfully.');
    }
}
