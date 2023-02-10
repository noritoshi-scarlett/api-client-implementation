<?php
use ApiClient\Request;
use ApiClient\Response;
use Nyholm\Psr7\Uri;

$apiClient = new ApiClient();

$request = new Request('GET', new Uri('http://example.com'), []);

$response = $request->withMethod('GET');

if (!$response instanceof Response) {
    echo 'eror instance of response object.';
    exit(1);
}

$body = $response->getBody();
exit(0);