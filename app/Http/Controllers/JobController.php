<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\Job;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::paginate(3);

        return response()->json(
            $jobs->toResourceCollection()
        );
    }

    public function show(string $id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        // $job = new JobResource($job);

        return response()->json(
            $job->toResource()
        );
    }

    public function store(Request $request)
    {

        Gate::authorize('create', Job::class);


        try {

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'salary' => 'required|numeric',
                'tags' => 'nullable|string',
                'job_type' => 'required|in:full-time,part-time,contract,temporary,internship,volunteer,on-call',
                'remote' => 'boolean',
                'requirements' => 'nullable|string',
                'benefits' => 'nullable|string',
                'address' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'nullable|string|max:10',
                'contact_email' => 'required|email|max:255',
                'contact_phone' => 'nullable|string|max:20',
                'company_name' => 'required|string|max:255',
                'company_description' => 'nullable|string',
                'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'company_website' => 'nullable|url|max:255',
            ], [
                'title.string' => 'The title must be a text.',
            ]);

            $validatedData['user_id'] = $request->user()->id;


            if ($request->hasFile('company_logo')) {
                $path = $request->file('company_logo')->store('logos', 'public');
                $validatedData['company_logo'] = $path;
            }

            $job = Job::create($validatedData);
            return response()->json($job, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 400); // Custom error code, e.g., 400 Bad Request
        }
    }

    public function update(Request $request, string $id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        Gate::authorize('modify', $job->user_id);

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'salary' => 'sometimes|required|numeric',
            'tags' => 'sometimes|nullable|string',
            'job_type' => 'sometimes|required|in:full-time,part-time,contract,temporary,internship,volunteer,on-call',
            'remote' => 'sometimes|boolean',
            'requirements' => 'sometimes|nullable|string',
            'benefits' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'zip_code' => 'sometimes|nullable|string|max:10',
            'contact_email' => 'sometimes|required|email|max:255',
            'contact_phone' => 'sometimes|nullable|string|max:20',
            'company_name' => 'sometimes|required|string|max:255',
            'company_description' => 'sometimes|nullable|string',
            'company_logo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'company_website' => 'sometimes|nullable|url|max:255',
        ]);

        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('logos', 'public');
            $validatedData['company_logo'] = $path;
        }

        $job->update($validatedData);
        return response()->json($job);
    }
    public function destroy(string $id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        Gate::authorize('modify', $job->user_id);

        if ($job->company_logo) {
            $path = public_path('storage/' . $job->company_logo);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $job->delete();
        return response()->json(['message' => 'Job deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = Job::query();

        if ($request->has('title')) {
            $query->where('title', 'ILIKE', '%' . $request->input('title') . '%');
        }

        if ($request->has('location')) {
            $query->where('city', 'ILIKE', '%' . $request->input('location') . '%')
                ->orWhere('state', 'ILIKE', '%' . $request->input('location') . '%');
        }

        if ($request->has('job_type')) {
            $query->where('job_type', $request->input('job_type'));
        }

        if ($request->has('remote')) {
            $query->where('remote', $request->input('remote'));
        }

        if ($request->has('salary_min')) {
            $query->where('salary', '>=', $request->input('salary_min'));
        }

        if ($request->has('salary_max')) {
            $query->where('salary', '<=', $request->input('salary_max'));
        }

        if ($request->has('tags')) {
            $tags = explode(',', $request->input('tags'));
            foreach ($tags as $tag) {
                $query->orWhere('tags', 'ILIKE', '%' . trim($tag) . '%');
            }
        }

        $jobs = $query->paginate(3);

        return response()->json(
            $jobs->toResourceCollection()
        );
    }
}
