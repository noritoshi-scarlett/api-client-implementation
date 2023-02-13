<?php

namespace Kamil\MerceApi\Exception;

use Psr\Http\Client\ClientExceptionInterface;

class ClientException implements ClientExceptionInterface
{
    use ExceptionTrait;
}