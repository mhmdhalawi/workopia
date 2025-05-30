<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{

    use HasUuids, HasFactory;

    protected $table = 'job_listings';
    protected $fillable = [
        'title',
        'description',
        'salary',
        'tags',
        'job_type',
        'remote',
        'requirements',
        'benefits',
        'address',
        'city',
        'state',
        'zip_code',
        'contact_email',
        'contact_phone',
        'company_name',
        'company_description',
        'company_logo',
        'company_website',
        'user_id',
    ];

    // relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relation to job user bookmarks
    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'job_user_bookmarks')
            ->withTimestamps();
    }

    // relation to applicants
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'job_id');
    }
}
