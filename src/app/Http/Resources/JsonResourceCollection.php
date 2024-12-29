<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @mixin LengthAwarePaginator
 */
class JsonResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseUrl = $this->appends($request->query());

        return [
            'data' => $this->collection,
            'links' => [
                'first' => $baseUrl->url(1),
                'last' => $baseUrl->url($this->lastPage()),
                'prev' => $baseUrl->previousPageUrl(),
                'next' => $baseUrl->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $baseUrl->currentPage(),
                'from' => $baseUrl->firstItem(),
                'last_page' => $baseUrl->lastPage(),
                'path' => $baseUrl->path(),
                'per_page' => $baseUrl->perPage(),
                'to' => $baseUrl->lastItem(),
                'total' => $baseUrl->total(),
            ],
        ];
    }
}
