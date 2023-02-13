<?php
namespace Kamil\MerceApi\ApiClient;

use Kamil\MerceApi\ApiClient\Request;
use Kamil\MerceApi\ApiClient\Response;

use Kamil\MerceApi\Exception\ClientException;
use Kamil\MerceApi\Middleware\ApiClientMiddlewareInterface;
use Nyholm\Psr7\Uri;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SebastianBergmann\Type\VoidType;

class ApiClient implements ClientInterface
{
    /**
     * @var array[ApiClientMiddlewareInterface]
     */
    private array $middlewares = [];

    /**
     * @var Uri
     */
    private Uri $uri;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var string
     */
    private string $cookiePath = '../files/cookie.txt';

    /**
     * @var string
     */
    private string $logsPath = '../logs/error.log';

    /**
     * @param string|null $errorLogPath
     */
    public function __construct(?string $errorLogPath = null)
    {
        if (isset($errorLogPath)) {
            $this->logsPath = $errorLogPath;
        }
    }

    /**
     * @param ApiClientMiddlewareInterface $middleware
     * 
     * @return self
     */
    public function withMiddleware(ApiClientMiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @return self
     */
    public function resetMiddlewares(): self
    {
        $this->middlewares = [];

        return $this;
    }

    /**
     * @param Uri $uri
     * 
     * @return self
     */
    public function withUri(Uri $uri): self
    {
        $this->uri = $uri;
        if (isset($this->request) && $this->request instanceof Request) {
            $this->request = $this->request->withUri($this->uri);
        } else {
            $this->request = new Request(Request::GET, $this->uri);
        }

        return $this;
    }

    /**
     * @param Request $request
     * 
     * @return self
     */
    public function withRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function sendGetRequest(): ResponseInterface
    {
        $this->checkRequestInstance();
        return $this->sendRequest($this->request->withMethod(Request::GET));
    }

    /**
     * @return ResponseInterface
     */
    public function sendPostRequest(): ResponseInterface
    {
        $this->checkRequestInstance();
        return $this->sendRequest($this->request->withMethod(Request::POST));
    }

    /**
     * @return ResponseInterface
     */
    public function sendPutRequest(): ResponseInterface
    {
        $this->checkRequestInstance();
        return $this->sendRequest($this->request->withMethod(Request::PUT));
    }

    /**
     * @return ResponseInterface
     */
    public function sendPatchRequest(): ResponseInterface
    {
        $this->checkRequestInstance();
        return $this->sendRequest($this->request->withMethod(Request::PATCH));
    }

    /**
     * @return ResponseInterface
     */
    public function sendDeleteRequest(): ResponseInterface
    {
        $this->checkRequestInstance();
        return $this->sendRequest($this->request->withMethod(Request::DELETE));
    }


    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        if (!$request instanceof Request) {
            throw new ClientException('Invalid class of Request instance. use Request from this library.');
        }

        try {
            $call = function () use ($request) {
                $ch = curl_init($request->getUri()->__toString());

                curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookiePath);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($ch);
                if (curl_error($ch)) {
                    $error = curl_error($ch);
                    file_put_contents($this->logsPath, $error);
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
        } catch (\Exception $e) {
            throw new ClientException('Error while send request.', $e->getCode(), $e);
        }

        return $response;
    }

    /**
     * @param string $headerAsString
     * 
     * @return array
     */
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

    /**
     * @param Request $basicRequest
     * @param callable $call
     * 
     * @return callback
     */
    private function pipeline(Request $basicRequest, callable $call)
    {
        $pipeline = array_reduce(
            array_reverse($this->middlewares),
            function ($nextClosure, $middlewareClass) {
                return function ($request) use ($nextClosure, $middlewareClass) {
                    return $middlewareClass->handleRequest($request, $nextClosure);
                };
            },
            function ($request) use ($call) {
                return $call($request);
            }
        );

        return $pipeline($basicRequest);
    }

    /**
     * @return void
     */
    private function checkRequestInstance(): void
    {
        if (!isset($this->request) && $this->uri instanceof Uri) {
            $this->request = new Request(Request::GET, $this->uri);
        }
        if (!$this->request instanceof Request) {
            throw new ClientException('Invalid request. Use `withRequest` method.');
        }
        if (!$this->request->getUri() instanceof Uri) {
            throw new ClientException('Invalid Uri in Request object.');
        }
    }
}