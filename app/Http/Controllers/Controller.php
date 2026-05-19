<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API Orphe',
    description: 'API REST de gestion de livres avec authentification Sanctum, pagination, cache et liens HATEOAS.'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000/api/v1',
    description: 'Serveur local API v1'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'Sanctum',
    description: 'Token obtenu via POST /login ou POST /register. Cliquez sur Authorize et saisissez : Bearer {votre_token}'
)]
#[OA\Tag(name: 'Auth', description: 'Inscription, connexion et déconnexion')]
#[OA\Tag(name: 'Books', description: 'Gestion des livres')]
abstract class Controller
{
    //
}
