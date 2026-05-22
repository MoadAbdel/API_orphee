<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'RegisterRequest',
    required: ['name', 'email', 'password'],
    properties: [
        new OA\Property(property: 'name', type: 'string', example: 'Jean Dupont'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'jean@example.com'),
        new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'LoginRequest',
    required: ['email', 'password'],
    properties: [
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'jean@example.com'),
        new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'User',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Jean Dupont'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'jean@example.com'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'AuthResponse',
    properties: [
        new OA\Property(property: 'token', type: 'string', example: '1|abcdefghijklmnopqrstuvwxyz'),
        new OA\Property(property: 'user', ref: '#/components/schemas/User'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'MessageResponse',
    properties: [
        new OA\Property(property: 'message', type: 'string', example: 'Déconnexion réussie'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'BookRequest',
    required: ['title', 'author', 'summary', 'isbn'],
    properties: [
        new OA\Property(property: 'title', type: 'string', example: '1984'),
        new OA\Property(property: 'author', type: 'string', example: 'George Orwell'),
        new OA\Property(property: 'summary', type: 'string', example: 'Roman dystopique décrivant une société totalitaire.'),
        new OA\Property(property: 'isbn', type: 'string', example: '9780451524935'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'BookLinks',
    properties: [
        new OA\Property(property: 'self', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books/1'),
        new OA\Property(property: 'update', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books/1'),
        new OA\Property(property: 'delete', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books/1'),
        new OA\Property(property: 'all', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'BookPaginationLinks',
    properties: [
        new OA\Property(property: 'self', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books?page=1'),
        new OA\Property(property: 'first', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books?page=1'),
        new OA\Property(property: 'last', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books?page=2'),
        new OA\Property(property: 'prev', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books?page=1', nullable: true),
        new OA\Property(property: 'next', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books?page=2', nullable: true),
        new OA\Property(property: 'all', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/v1/books'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'BookPaginationMeta',
    properties: [
        new OA\Property(property: 'current_page', type: 'integer', example: 1),
        new OA\Property(property: 'from', type: 'integer', example: 1),
        new OA\Property(property: 'last_page', type: 'integer', example: 2),
        new OA\Property(property: 'per_page', type: 'integer', example: 2),
        new OA\Property(property: 'to', type: 'integer', example: 2),
        new OA\Property(property: 'total', type: 'integer', example: 3),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PaginatedBooksResponse',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Book')),
        new OA\Property(property: '_links', ref: '#/components/schemas/BookPaginationLinks'),
        new OA\Property(property: 'meta', ref: '#/components/schemas/BookPaginationMeta'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'BookResponse',
    properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Book'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Book',
    properties: [
        new OA\Property(property: 'title', type: 'string', example: '1984'),
        new OA\Property(property: 'author', type: 'string', example: 'GEORGE ORWELL'),
        new OA\Property(property: 'summary', type: 'string', example: 'Roman dystopique décrivant une société totalitaire contrôlée par Big Brother.'),
        new OA\Property(property: 'isbn', type: 'string', example: '9780451524935'),
        new OA\Property(property: '_links', ref: '#/components/schemas/BookLinks'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ValidationError',
    properties: [
        new OA\Property(property: 'message', type: 'string', example: 'The email field is required.'),
        new OA\Property(
            property: 'errors',
            type: 'object',
            example: ['email' => ['The email field is required.']]
        ),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'UnauthorizedError',
    properties: [
        new OA\Property(property: 'message', type: 'string', example: 'Unauthenticated.'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'NotFoundError',
    properties: [
        new OA\Property(property: 'message', type: 'string', example: 'No query results for model [App\\Models\\Book].'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'LoginError',
    properties: [
        new OA\Property(property: 'message', type: 'string', example: 'Les identifiants sont incorrects.'),
    ],
    type: 'object'
)]
class OpenApiDefinitions
{
}
