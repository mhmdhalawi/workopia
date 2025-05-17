<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    use HasUuids;

    // This line is optional but explicitly tells Laravel the primary key is 'id'
    protected $primaryKey = 'id';

    // This tells Laravel the primary key is a string, not an integer
    protected $keyType = 'string';

    // This disables auto-incrementing as it doesn't apply to UUIDs
    public $incrementing = false;

    protected $table = 'job_listings';
    protected $fillable = [
        'title',
        'description',
    ];
}
