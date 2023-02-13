<?php

namespace Kamil\MerceApi\Tests;

use Kamil\MerceApi\ApiClient\ApiClient;
use Kamil\MerceApi\ApiClient\Request;
use Kamil\MerceApi\Middleware\BasicMiddleware;
use Nyholm\Psr7\Uri;
use PHPUnit\Framework\TestCase;

use Kamil\MerceApi\Tests\Config;

use Psr\Http\Message\RequestInterface;

class BasicMiddlewareTest extends TestCase
{

    public function testWithUserAndPasswordSuccess()
    {
        $requestBasic = new Request(Request::POST, new Uri());
        $middleware = new BasicMiddleware();

        $call = function(RequestInterface $request) {
            return $request;
        };

        $requestReturned = $middleware
                ->withUserAndPassword(Config::USERNAME, Config::PASSWORD)
                ->handleRequest($requestBasic, $call);

        $this->assertEquals(
            'Basic ' . Config::USERNAME_AND_PASSWORD_IN_BASE64,
            $requestReturned->getHeaderLine('Authorization')
        );
        
    }
    public function testWithSecretKeySuccess()
    {
        $requestBasic = new Request(Request::POST, new Uri());
        $middleware = new BasicMiddleware();

        $call = function(RequestInterface $request) {
            return $request;
        };

        $requestReturned = $middleware
                ->withSecretKey(Config::SECRET_KEY)
                ->handleRequest($requestBasic, $call);

        $this->assertEquals(
            'Basic ' . Config::SECRET_KEY_IN_BASE64,
            $requestReturned->getHeaderLine('Authorization')
        );
        
    }
}