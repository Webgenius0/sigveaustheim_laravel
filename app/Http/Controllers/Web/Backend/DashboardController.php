<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\User;
use App\Models\School;
use App\Models\Student;
use App\Models\FeedBack;
use App\Models\FitnessTests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     */
    public function index()
    {
        $user = auth()->user();

        // Get all statistics
        $totalUsers = User::count();
        $totalSchools = School::count();
        $totalStudents = Student::count();
        $totalTests = FitnessTests::count();
        $totalFeedbacks = FeedBack::count();

        // You can also add more specific counts if needed
        $approvedSchools = School::where('status', 'approved')->count();
        $pendingSchools = School::where('status', 'pending')->count();
        $activeFeedbacks = FeedBack::where('status', 1)->count();

        return view('backend.layouts.dashboard', compact(
            'totalUsers',
            'totalSchools',
            'totalStudents',
            'totalTests',
            'totalFeedbacks',
            'approvedSchools',
            'pendingSchools',
            'activeFeedbacks'
        ));
    }

    // Dashboad statistics
    public function getDashboardData()
    {
        // School status pie chart data
        $schoolStatuses = School::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });

        // New school registrations (last 30 days)
        $newSchoolRegistrations = School::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->count];
            });

        // New student registrations (last 30 days)
        $newStudentRegistrations = Student::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->count];
            });

        // Most popular fitness tests (test scores count)
        $popularTests = FitnessTests::leftJoin('test_scores', 'fitness_tests.id', '=', 'test_scores.fitness_test_id')
            ->selectRaw('fitness_tests.name, COUNT(test_scores.id) as attempt_count')
            ->groupBy('fitness_tests.id', 'fitness_tests.name')
            ->orderByDesc('attempt_count')
            ->limit(5)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->name => $item->attempt_count];
            });

        // Student gender distribution
        $genderDistribution = Student::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->gender => $item->count];
            });

        // Test attempts per day (last 30 days)
        $dailyTestAttempts = DB::table('test_scores')
            ->selectRaw('DATE(test_date) as date, COUNT(*) as count')
            ->where('test_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->count];
            });

        // Feedback ratings distribution
        $feedbackRatings = FeedBack::selectRaw('FLOOR(rating) as rating_floor, COUNT(*) as count')
            ->groupBy('rating_floor')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->rating_floor . ' Star' => $item->count];
            });

        return response()->json([
            // School data
            'school_statuses' => [
                'pending' => $schoolStatuses['pending'] ?? 0,
                'approved' => $schoolStatuses['approved'] ?? 0,
                'cancelled' => $schoolStatuses['cancelled'] ?? 0,
            ],
            'new_school_registrations' => $newSchoolRegistrations,

            // Student data
            'new_student_registrations' => $newStudentRegistrations,
            'gender_distribution' => [
                'male' => $genderDistribution['male'] ?? 0,
                'female' => $genderDistribution['female'] ?? 0,
            ],

            // Test data
            'popular_tests' => $popularTests,
            'daily_test_attempts' => $dailyTestAttempts,

            // Feedback data
            'feedback_ratings' => $feedbackRatings,
        ]);
    }
}
