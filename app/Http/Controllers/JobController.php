<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    //
    public function index()
    {
        return response()->json([
            [
                'id' => 1,
                'title' => 'Software Engineer',
                'company' => 'Tech Company',
                'location' => 'Remote',
                'description' => 'Develop and maintain software applications.',
            ],
            [
                'id' => 2,
                'title' => 'Data Analyst',
                'company' => 'Data Corp',
                'location' => 'On-site',
                'description' => 'Analyze and interpret complex data sets.',
            ],
        ]);
    }

    public function show(string $id)
    {
        // Logic to display a specific job listing
        return response()->json([
            'id' => $id,
            'title' => 'Software Engineer',
            'company' => 'Tech Company',
            'location' => 'Remote',
            'description' => 'Develop and maintain software applications.',
        ]);
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
