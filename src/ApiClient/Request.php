<?php

namespace Kamil\MerceApi\ApiClient;

class Request extends \Nyholm\Psr7\Request
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

}