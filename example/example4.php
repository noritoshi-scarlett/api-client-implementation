<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Kamil\MerceApi\ApiClient\ApiClient;
use Kamil\MerceApi\ApiClient\Request;
use Kamil\MerceApi\Middleware\BasicMiddleware;
use Kamil\MerceApi\Middleware\JWTMiddleware;
use Nyholm\Psr7\Uri;

// Przykład 1. Uzycie kilku middleware.
$apiClient = new ApiClient();
$uri = new Uri('https://www.google.com/');
// Dwa te same middlewery tylko dla pokazania przykładu
$middleware1 = (new BasicMiddleware())->withUserAndPassword('admin', 'tajne');
$middleware2 = (new BasicMiddleware())->withSecretKey('super-tajne');
$response = $apiClient
        ->withUri($uri)
        ->withMiddleware($middleware1)
        ->withMiddleware($middleware2)
        ->sendPostRequest();

// Przykład 2. Najpierw autoryzacja loginem i haslem, potem middlewere JWT za pomoca otryzmanego tokenu:
$apiClient = new ApiClient();
$uri = new Uri('https://www.google.com/');
$middlewareBasic = (new BasicMiddleware())->withUserAndPassword('admin', 'tajne');
$response = $apiClient
        ->withUri($uri)
        ->withMiddleware($middleware1)
        ->sendPostRequest();

$middlewareJWT = (new JWTMiddleware())->withJWTToken($response->getBody()->__toString());
$response = $apiClient
        ->resetMiddlewares()
        ->withMiddleware($middlewareJWT)
        ->sendGetRequest();