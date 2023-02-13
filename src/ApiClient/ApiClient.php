<?php
namespace Kamil\MerceApi\ApiClient;

use Kamil\MerceApi\ApiClient\Response;

use Kamil\MerceApi\Middleware\ApiClientMiddlewareInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiClient implements ClientInterface
{
    /**
     * @var array[ApiClientMiddlewareInterface]
     */
    private array $middlewares = [];

    public function withMiddleware(ApiClientMiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;
    
        return $this;
    }

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $call = function() use ($request) {
            $ch = curl_init($request->getUri()->__toString());

            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $error = curl_error($ch);
            }
            curl_close($ch);

            // STATUS CODE
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // RESPONSE HEADERS
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headerAsString = substr($result, 0, $headerSize);
            $bodyString = substr($result, $headerSize);
        
            return new Response($http_code, $this->headersToArray($headerAsString), $bodyString);
        };

        $response = $this->pipeline($request, $call);

        return $response;
    }

    private function headersToArray(string $headerAsString): array
    {
        $headers = [];
        $headerLines = explode("\r\n", $headerAsString);
        foreach ($headerLines as $line) {
            $colonIndex = strpos($line, ":");
            if ($colonIndex !== false) {
                $name = substr($line, 0, $colonIndex);
                $value = substr($line, $colonIndex + 1);
                $headers[$name] = $value;
            }
        }
        return $headers;
    }

    private function pipeline(RequestInterface $basicRequest, callable $call) {
        $pipeline = array_reduce(
            array_reverse($this->middlewares),
            function ($nextClosure, $middlewareClass) {
                return function ($request) use ($nextClosure, $middlewareClass) {
                    //$middleware = app($middlewareClass);
                    return $middlewareClass->handleRequest($request, $nextClosure);
                };
            },
            function ($request) use ($call) {
                return $call($request);
            }
        );

        return $pipeline($basicRequest);
    }
}