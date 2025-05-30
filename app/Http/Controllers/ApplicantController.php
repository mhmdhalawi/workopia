<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // show all applicants to the authenticated user
        // eager load user and job relationships to avoid N+1 query problem
        $applicants = Applicant::with(['user', 'job'])
            ->where('user_id', $request->user()->id)
            ->paginate(10);

        return response()->json(
            $applicants,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->user()->id;

        // check if the user already applied for the job
        $existingApplicant = Applicant::where('user_id', $user_id)
            ->where('job_id', $request->input('job_id'))
            ->first();

        if ($existingApplicant) {
            return response()->json(['error' => 'You have already applied for this job'], 422);
        }

        // Add user_id to the request data
        $request->merge(['user_id' => $user_id]);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:job_listings,id',
            'full_name' => 'required|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'required|email|max:255',
            'location' => 'nullable|string|max:255',
            'cover_letter' => 'nullable|string',
        ]);

        // Handle file upload for resume
        if ($request->hasFile('resume_file')) {
            $data['resume_file_path'] = $request->file('resume_file')->store('resumes', 'public');
        } else {
            return response()->json(['error' => 'Resume file is required'], 422);
        }
        // Create the applicant
        $applicant = Applicant::create($data);

        return response()->json(
            $applicant,
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $applicant = Applicant::with(['job'])->find($id);

        if (!$applicant) {
            return response()->json(['error' => 'Applicant not found'], 404);
        }


        Gate::authorize('view', [Job::class, $applicant->user_id]);



        return response()->json(
            $applicant->toResourceArray(),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return response()->json(['error' => 'Applicant not found'], 404);
        }

        Gate::authorize('modify', $applicant->job_id);

        $data = $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'sometimes|required|email|max:255',
            'location' => 'nullable|string|max:255',
            'cover_letter' => 'nullable|string',
            'status' => 'sometimes|required|in:applied,interviewed,offered,hired,rejected',
        ]);

        // Handle file upload for resume
        if ($request->hasFile('resume_file')) {
            // check if the applicant has an existing resume file
            if ($applicant->resume_file_path) {
                Storage::disk('public')->delete($applicant->resume_file_path);
            }

            $data['resume_file_path'] = $request->file('resume_file')->store('resumes', 'public');
        }

        $applicant->update($data);

        return response()->json(
            $applicant,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $applicant = Applicant::find($id);

        if (!$applicant) {
            return response()->json(['error' => 'Applicant not found'], 404);
        }

        Gate::authorize('modify', $applicant->job_id);

        // Delete the resume file if it exists
        if ($applicant->resume_file_path) {
            Storage::disk('public')->delete($applicant->resume_file_path);
        }

        $applicant->delete();

        return response()->json(['message' => 'Applicant deleted successfully'], 200);
    }
}
