<?php

namespace Kamil\MerceApi\Tests;

use Kamil\MerceApi\ApiClient\ApiClient;
use Kamil\MerceApi\ApiClient\Request;
use Kamil\MerceApi\Middleware\BasicMiddleware;

use Nyholm\Psr7\Uri;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

use Kamil\MerceApi\Tests\Config;

include_once __DIR__ . '/../../vendor/autoload.php';

class RequestTest extends TestCase
{

    private ApiClient $apiClient;

    private Uri $uri;

    /**
     * @before
     */
    public function before()
    {
        $this->apiClient = new ApiClient();
        $this->uri = new Uri(Config::URL);
    }

    public function testBasicAuthWithSuccess()
    {
        $middleware = (new BasicMiddleware())
            ->withUserAndPassword(Config::USERNAME, Config::PASSWORD);
        $request = new Request(Request::GET, $this->uri);

        $response = $this->apiClient->withMiddleware($middleware)->sendRequest($request);

        $this->assertEquals(200, $response->getStatusCode(), 'status code');
    }

    public function testGetActivity()
    {
        $uri = $this->uri->withPath('api/activity');
        $request = new Request(Request::GET, $uri);
        
        $response = $this->apiClient->withRequest($request)->sendGetRequest();
        $responseBody = $response->asArray();

        $this->assertEquals('https://www.boredapi.com/api/activity', $request->getUri()->__toString(), 'url');
        $this->assertEquals(200, $response->getStatusCode(), 'status code');
        $this->assertArrayHasKey('activity', $responseBody, 'body has activity item');
        $this->assertArrayHasKey('type', $responseBody, 'body has type item');
    }

    public function testGetActivityWithKey()
    {
        $uri = $this->uri->withPath('api/activity')->withQuery('key=5881028');
        $request = new Request(Request::GET, $uri);
        
        $response = $this->apiClient->withRequest($request)->sendGetRequest();
        $responseBody = $response->asObject();

        $this->assertEquals(200, $response->getStatusCode(), 'status code');
        $this->assertEquals(5881028, $responseBody->key);
    }



}