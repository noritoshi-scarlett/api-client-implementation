<?php

namespace Kamil\MerceApi\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ApiClientMiddlewareInterface
{

    public function handleRequest(RequestInterface $request, callable $next);

    public function handleResponse(RequestInterface $request, ResponseInterface $response, callable $next);

}