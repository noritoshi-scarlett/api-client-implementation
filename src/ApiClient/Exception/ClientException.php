<?php

namespace Kamil\MerceApi\Exception;

use Psr\Http\Client\ClientExceptionInterface;

class ClientException extends \RuntimeException implements ClientExceptionInterface
{
    use ExceptionTrait;
}