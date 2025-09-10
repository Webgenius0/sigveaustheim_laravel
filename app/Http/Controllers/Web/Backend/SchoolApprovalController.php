<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\School;
use App\Http\Controllers\Controller;

class SchoolApprovalController extends Controller
{
    /**
     * Summary of approve school
     */
    public function approveFromEmail($token)
    {
        $school = School::where('approval_token', $token)->first();

        // Token invalid or already used
        if (!$school) {
            abort(404, 'School not found or approval token is invalid.');
        }

        // Already approved/cancelled
        if ($school->status !== 'pending') {
            return redirect()->route('dashboard')
                ->with('t-error', 'This school is already ' . $school->status);
        }

        // Must be logged in as admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')
                ->with('t-error', 'You must login as admin to approve.');
        }

        // Update approval status
        $school->update([
            'status'        => 'approved',
            'approved_by'   => auth()->id(),
            'approved_at'   => now(),
            'approval_token' => null,
        ]);

        return redirect()->route('dashboard')
            ->with('t-success', 'School approved successfully.');
    }


    /**
     * Summary of cancel school
     */
    public function cancelFromEmail($token)
    {
        $user = auth('web')->user();

        $school = School::where('approval_token', $token)->first();

        if (!$school) {
            // Browser flow (email click) → 404 page or friendly error page
            abort(404, 'School not found or already cancelled.');
        }

        if ($school->status !== 'pending') {
            return redirect()->route('dashboard')
                ->with('t-error', 'This school is already ' . $school->status);
        }

        if (!$user || $user->role !== 'admin') {
            return redirect()->route('login')
                ->with('t-error', 'You must login as admin to cancel.');
        }

        $school->update([
            'status'        => 'cancelled',
            'cancelled_by'  => $user->id,
            'cancelled_at'  => now(),
            'approval_token' => null,
        ]);

        return redirect()->route('dashboard')
            ->with('t-success', 'School cancelled successfully.');
    }
}
