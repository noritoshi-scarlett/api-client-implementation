<?php
namespace Kamil\MerceApi\Exception;

use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\RequestInterface;

class NetworkException implements NetworkExceptionInterface
{

    use ExceptionTrait;

    /**
     * Returns the request.
     *
     * The request object MAY be a different object from the one passed to ClientInterface::sendRequest()
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
    }


}