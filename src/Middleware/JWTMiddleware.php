<?php

namespace Kamil\MerceApi\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use Kamil\MerceApi\Exception\ClientException;

class JWTMiddleware implements ApiClientMiddlewareInterface
{
    private string $token;

    private $headerValue;

    /**
     * @param string $token Access token.
     * 
     * @return self
     */
    public function withJWTToken(string $token): self
    {
        if (empty($token)) {
            throw new ClientException('Given empty token in ' . self::class);
        }

        $this->headerValue = "Bearer " . base64_encode("$token");

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