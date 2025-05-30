<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            $this->resource->toArray(), // All model attributes
            [
                'is_bookmarked' => $this->bookmarks->contains($request->user()->id), // Bookmark status
            ]
        );
    }
}
