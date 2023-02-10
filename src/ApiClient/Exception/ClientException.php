<?php
use Psr\Http\Client\ClientExceptionInterface;

class ClientException implements ClientExceptionInterface
{

    use ExceptionTrait;
}