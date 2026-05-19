<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OpenApi\Attributes as OA;

class BookController extends Controller
{
    #[OA\Get(
        path: '/books',
        summary: 'Liste paginée des livres',
        description: 'Renvoie les livres par pages de 2 éléments avec liens HATEOAS.',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                schema: new OA\Schema(type: 'string', default: 'application/json')
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                description: 'Numéro de page',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des livres',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Book')
                        ),
                        new OA\Property(property: 'links', type: 'object'),
                        new OA\Property(property: 'meta', type: 'object'),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
    public function index()
    {
        return BookResource::collection(Book::paginate(2));
    }

    #[OA\Post(
        path: '/books',
        summary: 'Créer un livre',
        description: 'Ajoute un nouveau livre. Authentification Sanctum requise.',
        tags: ['Books'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                schema: new OA\Schema(type: 'string', default: 'application/json')
            ),
            new OA\Parameter(
                name: 'Authorization',
                in: 'header',
                required: true,
                description: 'Bearer {token}',
                schema: new OA\Schema(type: 'string', example: 'Bearer 1|abcdefghijklmnopqrstuvwxyz')
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/BookRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Livre créé',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/Book'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Non authentifié',
                content: new OA\JsonContent(ref: '#/components/schemas/UnauthorizedError')
            ),
            new OA\Response(
                response: 422,
                description: 'Erreur de validation',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
        ]
    )]
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

    #[OA\Get(
        path: '/books/{book}',
        summary: 'Détail d\'un livre',
        description: 'Renvoie les détails d\'un livre (mis en cache 60 minutes).',
        tags: ['Books'],
        parameters: [
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                schema: new OA\Schema(type: 'string', default: 'application/json')
            ),
            new OA\Parameter(
                name: 'book',
                in: 'path',
                required: true,
                description: 'ID du livre',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détail du livre',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/Book'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Livre introuvable',
                content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError')
            ),
        ]
    )]
    public function show(Book $book)
    {
        $book = Cache::remember(
            "book.{$book->id}",
            now()->addMinutes(60),
            fn () => $book->fresh()
        );

        return new BookResource($book);
    }

    #[OA\Put(
        path: '/books/{book}',
        summary: 'Mettre à jour un livre',
        description: 'Met à jour un livre existant. Authentification Sanctum requise.',
        tags: ['Books'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                schema: new OA\Schema(type: 'string', default: 'application/json')
            ),
            new OA\Parameter(
                name: 'Authorization',
                in: 'header',
                required: true,
                description: 'Bearer {token}',
                schema: new OA\Schema(type: 'string', example: 'Bearer 1|abcdefghijklmnopqrstuvwxyz')
            ),
            new OA\Parameter(
                name: 'book',
                in: 'path',
                required: true,
                description: 'ID du livre',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/BookRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Livre mis à jour',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/Book'),
                    ],
                    type: 'object'
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Non authentifié',
                content: new OA\JsonContent(ref: '#/components/schemas/UnauthorizedError')
            ),
            new OA\Response(
                response: 404,
                description: 'Livre introuvable',
                content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError')
            ),
            new OA\Response(
                response: 422,
                description: 'Erreur de validation',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationError')
            ),
        ]
    )]
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

    #[OA\Delete(
        path: '/books/{book}',
        summary: 'Supprimer un livre',
        description: 'Supprime un livre. Authentification Sanctum requise.',
        tags: ['Books'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'Accept',
                in: 'header',
                required: true,
                schema: new OA\Schema(type: 'string', default: 'application/json')
            ),
            new OA\Parameter(
                name: 'Authorization',
                in: 'header',
                required: true,
                description: 'Bearer {token}',
                schema: new OA\Schema(type: 'string', example: 'Bearer 1|abcdefghijklmnopqrstuvwxyz')
            ),
            new OA\Parameter(
                name: 'book',
                in: 'path',
                required: true,
                description: 'ID du livre',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Livre supprimé'),
            new OA\Response(
                response: 401,
                description: 'Non authentifié',
                content: new OA\JsonContent(ref: '#/components/schemas/UnauthorizedError')
            ),
            new OA\Response(
                response: 404,
                description: 'Livre introuvable',
                content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError')
            ),
        ]
    )]
    public function destroy(Book $book)
    {
        Cache::forget("book.{$book->id}");

        $book->delete();

        return response()->noContent();
    }
}
