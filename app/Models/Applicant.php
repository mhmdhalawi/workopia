<?php

namespace App\Models;

use App\Http\Resources\JobResource;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    //
    protected $fillable = [
        'user_id',
        'job_id',
        'full_name',
        'contact_phone',
        'contact_email',
        'location',
        'cover_letter',
        'resume_file_path',
        'status',
    ];

    // relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relationship with Job
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }


    // Add a method to get formatted data
    public function toResourceArray()
    {
        $data = $this->toArray();

        if ($this->relationLoaded('job')) {
            $data['job'] = (new JobResource($this->job))->toArray(request());
        }

        return $data;
    }
}
