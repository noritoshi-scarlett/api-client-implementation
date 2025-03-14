<?php

namespace Kamil\MerceApi\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BasicMiddleware implements ApiClientMiddlewareInterface
{
    private string $headerValue;

    /**
     * @param string $username Username.
     * @param string $password Password.
     * 
     * @return self
     */
    public function withUserAndPassword(string $username, string $password): self
    {
        $this->headerValue = "Basic " . base64_encode("$username:$password");

        return $this;
    }

    /**
     * @param string $secretKey Secret key.
     * 
     * @return self
     */
    public function withSecretKey(string $secretKey): self
    {
        $this->headerValue = "Basic " . base64_encode("$secretKey");

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @param Closure $next
     * @return mixed
     */
    public function handleRequest(RequestInterface $request, callable $next)
    {
        $newRequest = $request->withAddedHeader('Authorization', $this->headerValue);
        return $next($newRequest);
    }

    /**
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param Closure $next
     * @return mixed
     */
    public function handleResponse(RequestInterface $request, ResponseInterface $response, callable $next)
    {
    }
}