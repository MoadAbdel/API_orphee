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
        new OA\Property(property: 'self', type: 'string', format: 'uri'),
        new OA\Property(property: 'update', type: 'string', format: 'uri'),
        new OA\Property(property: 'delete', type: 'string', format: 'uri'),
        new OA\Property(property: 'all', type: 'string', format: 'uri'),
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
