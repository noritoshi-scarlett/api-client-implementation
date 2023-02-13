<?php
use Kamil\MerceApi\ApiClient\ApiClient;
use Kamil\MerceApi\ApiClient\Request;
use Kamil\MerceApi\Middleware\BasicMiddleware;

use Nyholm\Psr7\Uri;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

include_once __DIR__.'/../../vendor/autoload.php';

class RequestTest extends TestCase
{
    private const USERNAME = 'admin';
    private const PASSWORD = '1234';

    private const URL = 'https://www.boredapi.com/api/';

    private ApiClient $apiClient;

    private Uri $uri;

    /**
     * @before
     */
    public function before()
    {
        $this->apiClient = new ApiClient();
        $this->uri = new Uri(self::URL);
    }

     public function testBasicAuthWithSuccess() {
    
        $middleware = (new BasicMiddleware())
                ->withUserAndPassword(self::USERNAME, self::PASSWORD);
        $request = new Request(Request::GET, $this->uri);
        $middleware->handleRequest($request, function($request) {});
        $response = $this->apiClient->withMiddleware($middleware)->sendRequest($request);

        $this->assertEquals(200, $response->getStatusCode(), 'status code');
    }

    public function testGetActivity() {
    
        $uri = $this->uri->withPath('api/activity');
        $request = new Request(Request::GET, $uri);
        $response = $this->apiClient->sendRequest($request);
        $responseBody = json_decode($response->getBody()->__toString(), true);

        $this->assertEquals('https://www.boredapi.com/api/activity', $request->getUri()->__toString(), 'url');
        $this->assertEquals(200, $response->getStatusCode(), 'status code');
        $this->assertArrayHasKey('activity', $responseBody, 'body');
        $this->assertArrayHasKey('type', $responseBody, 'body');
    }

}