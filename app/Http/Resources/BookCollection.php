<?php

namespace App\Http\Resources;

use App\Http\Concerns\GeneratesApiUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    use GeneratesApiUrls;

    public $collects = BookResource::class;

    public function paginationInformation($request, $paginated, $default): array
    {
        $pageQuery = array_merge($request->except('page'), [
            'page' => $paginated['current_page'],
        ]);

        return [
            '_links' => array_filter([
                'self' => $paginated['path'].'?'.http_build_query($pageQuery),
                'first' => $paginated['first_page_url'],
                'last' => $paginated['last_page_url'],
                'prev' => $paginated['prev_page_url'] ?? null,
                'next' => $paginated['next_page_url'] ?? null,
                'all' => $this->apiUrl('books.index'),
            ], fn ($url) => $url !== null),
            'meta' => [
                'current_page' => $paginated['current_page'],
                'from' => $paginated['from'],
                'last_page' => $paginated['last_page'],
                'per_page' => $paginated['per_page'],
                'to' => $paginated['to'],
                'total' => $paginated['total'],
            ],
        ];
    }
}
