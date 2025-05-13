<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/jobs', function () {

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
})->name('jobs');
