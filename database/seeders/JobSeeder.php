<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get all listings from data/job_listings.json
        $jobListings = include database_path('seeders/data/job_listings.php');

        $userIds = User::pluck('id')->toArray();

        foreach ($jobListings as $jobListing) {
            // get a random user id
            $jobListing['user_id'] = $userIds[array_rand($userIds)];

            // add timestamps
            $jobListing['created_at'] = now();
            $jobListing['updated_at'] = now();

            // create the job listing
            Job::create($jobListing);
        }
    }
}
