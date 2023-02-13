<?php

namespace Kamil\MerceApi\Exception;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;

class RequestException extends \RuntimeException implements RequestExceptionInterface
{
    //use ExceptionTrait;

    private RequestInterface $request;
    /**
     * Returns the request.
     *
     * The request object MAY be a different object from the one passed to ClientInterface::sendRequest()
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

}