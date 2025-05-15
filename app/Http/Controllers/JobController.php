<?php

namespace App\Http\Controllers;

use App\Models\Job;

use Illuminate\Http\Request;

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
        // Logic to store a new job listing
        return response()->json([
            'message' => 'Job listing created successfully.',
            'data' => $request->all(),
        ]);
    }
}
