<?php
use Psr\Http\Client\ClientInterface;

class ApiClient implements ClientInterface
{

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param Psr\Http\Message\RequestInterface $request
     * @return Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(Psr\Http\Message\RequestInterface $request): Psr\Http\Message\ResponseInterface
    {
    }
}