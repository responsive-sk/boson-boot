<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure\Http\Psr15;

use Boson\Shared\Infrastructure\Http\Psr15\Middleware\Psr15LoggingMiddleware;
use Boson\Shared\Infrastructure\Http\Psr15\Psr15Kernel;
use Boson\Shared\Infrastructure\Http\Psr15\PsrRequestAdapter;
use Boson\Shared\Infrastructure\Http\Psr15\PsrResponseAdapter;
use Boson\Shared\Infrastructure\Http\RequestHandler;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Integration test for PSR-15 functionality
 */
class Psr15IntegrationTest extends TestCase
{
    private Psr15Kernel $psr15Kernel;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $requestHandler = $this->createMock(RequestHandler::class);

        // Mock the request handler to return a simple response
        $requestHandler->method('handle')->willReturn([
            'status' => 200,
            'headers' => ['Content-Type' => 'application/json'],
            'body' => '{"message": "Hello PSR-15"}'
        ]);

        $this->psr15Kernel = new Psr15Kernel($requestHandler);
    }

    public function testPsr15ModeDisabledByDefault(): void
    {
        $this->assertFalse($this->psr15Kernel->isPsr15Mode());
    }

    public function testEnablePsr15Mode(): void
    {
        $this->psr15Kernel->enablePsr15Mode();
        $this->assertTrue($this->psr15Kernel->isPsr15Mode());
    }

    public function testDisablePsr15Mode(): void
    {
        $this->psr15Kernel->enablePsr15Mode();
        $this->psr15Kernel->disablePsr15Mode();
        $this->assertFalse($this->psr15Kernel->isPsr15Mode());
    }

    public function testAddPsr15Middleware(): void
    {
        $middleware = $this->createMock(\Psr\Http\Server\MiddlewareInterface::class);
        $this->psr15Kernel->enablePsr15Mode();
        $this->psr15Kernel->addPsr15Middleware($middleware);

        $middlewares = $this->psr15Kernel->getPsr15Stack()->getMiddlewares();
        $this->assertContains($middleware, $middlewares);
    }

    public function testHandlePsr7Request(): void
    {
        $this->psr15Kernel->enablePsr15Mode();

        // Create a mock PSR-7 request
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getServerParams')->willReturn(['REQUEST_METHOD' => 'GET']);
        $request->method('getQueryParams')->willReturn([]);
        $request->method('getParsedBody')->willReturn(null);
        $request->method('getHeaders')->willReturn([]);
        $request->method('getAttributes')->willReturn([]);
        $request->method('getMethod')->willReturn('GET');
        $request->method('getUri')->willReturn($this->createMock(\Psr\Http\Message\UriInterface::class));

        $response = $this->psr15Kernel->handlePsr7($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testHandleArrayRequest(): void
    {
        $this->psr15Kernel->enablePsr15Mode();

        $arrayRequest = [
            'method' => 'GET',
            'uri' => '/test',
            'server' => ['REQUEST_METHOD' => 'GET'],
            'get' => [],
            'post' => [],
            'headers' => [],
            'attributes' => [],
        ];

        $response = $this->psr15Kernel->handleArray($arrayRequest);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('headers', $response);
        $this->assertArrayHasKey('body', $response);
    }

    public function testPsr15LoggingMiddleware(): void
    {
        $this->psr15Kernel->enablePsr15Mode();

        // Add logging middleware
        $loggingMiddleware = new Psr15LoggingMiddleware($this->logger);
        $this->psr15Kernel->addPsr15Middleware($loggingMiddleware);

        // Create a mock PSR-7 request
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getServerParams')->willReturn(['REQUEST_METHOD' => 'GET']);
        $request->method('getQueryParams')->willReturn([]);
        $request->method('getParsedBody')->willReturn(null);
        $request->method('getHeaders')->willReturn([]);
        $request->method('getAttributes')->willReturn([]);
        $request->method('getMethod')->willReturn('GET');
        $request->method('getUri')->willReturn($this->createMock(\Psr\Http\Message\UriInterface::class));

        // Expect logger to be called
        $this->logger->expects($this->once())->method('info');

        $response = $this->psr15Kernel->handlePsr7($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testRequestAdapter(): void
    {
        $arrayRequest = [
            'method' => 'POST',
            'uri' => '/api/test',
            'server' => ['REQUEST_METHOD' => 'POST', 'REQUEST_URI' => '/api/test'],
            'get' => ['param' => 'value'],
            'post' => ['data' => 'test'],
            'headers' => ['Content-Type' => 'application/json'],
            'attributes' => ['route' => 'test'],
        ];

        $psrRequest = new PsrRequestAdapter($arrayRequest);

        $this->assertInstanceOf(ServerRequestInterface::class, $psrRequest);
        $this->assertEquals('POST', $psrRequest->getMethod());
        $this->assertEquals(['param' => 'value'], $psrRequest->getQueryParams());
        $this->assertEquals(['data' => 'test'], $psrRequest->getParsedBody());
        $this->assertEquals(['Content-Type' => 'application/json'], $psrRequest->getHeaders());
        $this->assertEquals(['route' => 'test'], $psrRequest->getAttributes());
    }

    public function testResponseAdapter(): void
    {
        $psrResponse = new PsrResponseAdapter(201, 'Created', ['Location' => '/resource/1']);
        $psrResponse->getBody()->write('{"id": 1}');

        $this->assertInstanceOf(ResponseInterface::class, $psrResponse);
        $this->assertEquals(201, $psrResponse->getStatusCode());
        $this->assertEquals('Created', $psrResponse->getReasonPhrase());
        $this->assertEquals(['Location' => '/resource/1'], $psrResponse->getHeaders());
        $this->assertEquals('{"id": 1}', (string) $psrResponse->getBody());

        // Test array conversion
        $arrayResponse = $psrResponse->toArrayResponse();
        $this->assertEquals(201, $arrayResponse['status']);
        $this->assertEquals(['Location' => '/resource/1'], $arrayResponse['headers']);
        $this->assertEquals('{"id": 1}', $arrayResponse['body']);
    }
}
