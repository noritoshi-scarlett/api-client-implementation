<?php
use Psr\Http\Client\RequestExceptionInterface;

class RequestException implements RequestExceptionInterface
{

    use ExceptionTrait;

    /**
     * Returns the request.
     *
     * The request object MAY be a different object from the one passed to ClientInterface::sendRequest()
     * @return Psr\Http\Message\RequestInterface
     */
    public function getRequest(): Psr\Http\Message\RequestInterface
    {
    }

}