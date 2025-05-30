<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('job_id')->constrained('job_listings')->onDelete('cascade');
            $table->string('full_name');
            $table->string('contact_phone')->nullable();
            $table->string('contact_email');
            $table->string('location')->nullable();
            $table->text('cover_letter')->nullable();
            $table->string('resume_file_path');
            $table->enum('status', ['applied', 'interviewed', 'offered', 'hired', 'rejected'])->default('applied');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
