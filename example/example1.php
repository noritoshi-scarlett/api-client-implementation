<?php


include_once __DIR__ . '/../vendor/autoload.php';

use Kamil\MerceApi\ApiClient\ApiClient;
use Kamil\MerceApi\ApiClient\Request;
use Kamil\MerceApi\ApiClient\Response;
use Nyholm\Psr7\Uri;
use Kamil\MerceApi\Middleware\BasicMiddleware;


$apiClient = new ApiClient();

$request = new Request(Request::GET, new Uri('https://www.google.com/'));

$response = $apiClient->sendRequest($request);

if (!$response instanceof Response) {
    echo 'eror instance of response object.';
    exit();
}

$bodyString = $response->getBody()->__toString();
$statusCode = $response->getStatusCode();
echo 'status code: ' . $statusCode;
//var_dump($bodyString);



////////