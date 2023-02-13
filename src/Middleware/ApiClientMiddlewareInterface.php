<?php

namespace Kamil\MerceApi\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ApiClientMiddlewareInterface
{

    /**
     * @param RequestInterface $request
     * @param callable $next
     * 
     * @return [type]
     */
    public function handleRequest(RequestInterface $request, callable $next);

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * 
     * @return [type]
     */
    public function handleResponse(RequestInterface $request, ResponseInterface $response, callable $next);

}