<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(3),
            'salary' => $this->faker->numberBetween(30000, 120000),
            'tags' => implode(',', $this->faker->words(3)),
            'job_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'temporary', 'internship', 'volunteer', 'on-call']),
            'remote' => $this->faker->boolean(),
            'requirements' => $this->faker->paragraph(2),
            'benefits' => $this->faker->paragraph(2),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'zip_code' => $this->faker->postcode(),
            'contact_email' => $this->faker->safeEmail(),
            'contact_phone' => $this->faker->phoneNumber(),
            'company_name' => $this->faker->company(),
            'company_description' => $this->faker->paragraph(2),
            'company_logo' => $this->faker->imageUrl(100, 100, 'business', true, 'company logo'),
            'company_website' => $this->faker->url(),
        ];
    }
}
