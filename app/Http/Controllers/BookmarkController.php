<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    //

    public function index(Request $request)
    {
        // Fetch the authenticated user
        $user = $request->user();

        // Get the user's bookmarked jobs
        $bookmarkedJobs = $user->jobBookmarks;


        $bookmarkedJobs = $bookmarkedJobs->map(function ($job) {
            return $job->makeHidden(['pivot']);
        });

        return response()->json($bookmarkedJobs);
    }

    public function show(Request $request, $jobId)
    {
        // Fetch the authenticated user
        $user = $request->user();

        // Find the job by ID
        $job = Job::findOrFail($jobId);

        // Check if the job is bookmarked by the user
        $isBookmarked = $user->jobBookmarks()->where('job_id', $jobId)->exists();

        // Return the job and its bookmark status
        $job->is_bookmarked = $isBookmarked;
        return response()->json($job);
    }
    public function toggleBookmark(Request $request, $jobId)
    {
        // Fetch the authenticated user
        $user = $request->user();

        // Find the job by ID
        $job = Job::findOrFail($jobId);

        // Check if the job is already bookmarked
        if ($user->jobBookmarks()->where('job_id', $jobId)->exists()) {
            // If bookmarked, detach it
            $user->jobBookmarks()->detach($job);
            return response()->json(['message' => 'Job bookmark removed successfully.']);
        } else {
            // If not bookmarked, attach it
            $user->jobBookmarks()->attach($job);
            return response()->json(['message' => 'Job bookmarked successfully.']);
        }
    }
}
