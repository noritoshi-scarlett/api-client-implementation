<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Kamil\MerceApi\ApiClient\ApiClient;
use Kamil\MerceApi\ApiClient\Request;
use Nyholm\Psr7\Uri;

// Przykład 1. Bez definicji requesta, tylko uri.
// Request zostanie stworzony z metodą GET, chyba że użyto funkcji sendPostRequest/sendtPutRequest etc.
$apiClient = new ApiClient();
$uri = new Uri('https://www.google.com/');
$response = $apiClient->withUri($uri)->sendPostRequest();

// Przykład 2. Z przekazaniem Requesta.
$apiClient = new ApiClient();
$uri = new Uri('https://www.google.com/');
$request = new Request(Request::GET, $uri);
$response = $apiClient->withRequest($request)->sendGetRequest();

//Modyfikacja uri przed kolejnym zapytaniem:
$response = $apiClient->withUri($uri->withQuery('?search?q=test'))->sendGetRequest();
