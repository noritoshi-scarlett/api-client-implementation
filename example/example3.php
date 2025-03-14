<?php

include_once __DIR__ . '/../vendor/autoload.php';

use Kamil\MerceApi\ApiClient\ApiClient;
use Nyholm\Psr7\Uri;

// Przykład 1. Zle uzycie, rzucenie wyjatku
// Request powinien byc instancją klasy Kamil\MerceApi\ApiClient\Request;
// Tylko ze nei rzuca wyjatku bo mi psr4 nie widzi klasy Exception :/
$apiClient = new ApiClient();
$uri = new Uri('https://www.google.com/');
$request = new Nyholm\Psr7\Request('GET', $uri);
$response = $apiClient->sendRequest($request);

