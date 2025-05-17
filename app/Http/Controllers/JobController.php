<?php

namespace App\Http\Controllers;

use App\Models\Job;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    //
    public function index()
    {
        return response()->json(
            Job::all()
        );
    }

    public function show(string $id)
    {
        // Logic to display a specific job listing
        return response()->json(
            Job::find($id)
        );
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ], [
                'title.string' => 'The title must be a text.',
            ]);

            $job = Job::create($validatedData);
            return response()->json($job, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 400); // Custom error code, e.g., 400 Bad Request
        }
    }
}
