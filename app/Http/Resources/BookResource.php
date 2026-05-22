<?php

namespace App\Http\Resources;

use App\Http\Concerns\GeneratesApiUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    use GeneratesApiUrls;

    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'author' => strtoupper($this->author),
            'summary' => $this->summary,
            'isbn' => $this->isbn,
            '_links' => [
                'self' => $this->apiUrl('books.show', ['book' => $this->id]),
                'update' => $this->apiUrl('books.update', ['book' => $this->id]),
                'delete' => $this->apiUrl('books.destroy', ['book' => $this->id]),
                'all' => $this->apiUrl('books.index'),
            ],
        ];
    }
}
