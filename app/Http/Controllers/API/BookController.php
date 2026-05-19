<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    public function index()
    {
        return BookResource::collection(Book::paginate(2));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'author' => 'required|string|min:3|max:100',
            'summary' => 'required|string|min:10|max:500',
            'isbn' => 'required|string|size:13|unique:books,isbn',
        ]);

        $book = Book::create($validated);

        return new BookResource($book);
    }

    public function show(Book $book)
    {
        $book = Cache::remember(
            "book.{$book->id}",
            now()->addMinutes(60),
            fn () => $book->fresh()
        );

        return new BookResource($book);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'author' => 'required|string|min:3|max:100',
            'summary' => 'required|string|min:10|max:500',
            'isbn' => 'required|string|size:13|unique:books,isbn,' . $book->id,
        ]);

        $book->update($validated);

        Cache::forget("book.{$book->id}");

        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        Cache::forget("book.{$book->id}");

        $book->delete();

        return response()->noContent();
    }
}
