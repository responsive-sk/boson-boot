<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Psr15;

use Boson\Shared\Infrastructure\Http\Middleware\MiddlewareStack;
use Boson\Shared\Infrastructure\Http\RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Psr15MiddlewareInterface;

/**
 * PSR-15 compatible kernel that integrates with existing middleware system
 */
class Psr15Kernel
{
    private Psr15MiddlewareStack $psr15Stack;
    private MiddlewareStack $customStack;
    private RequestHandler $requestHandler;
    private bool $usePsr15Mode = false;

    public function __construct(RequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
        $this->psr15Stack = new Psr15MiddlewareStack(new Psr15RequestHandler($requestHandler));
        $this->customStack = new MiddlewareStack($requestHandler);
    }

    /**
     * Enable PSR-15 mode
     */
    public function enablePsr15Mode(): self
    {
        $this->usePsr15Mode = true;
        return $this;
    }

    /**
     * Disable PSR-15 mode (use custom middleware)
     */
    public function disablePsr15Mode(): self
    {
        $this->usePsr15Mode = false;
        return $this;
    }

    /**
     * Add PSR-15 middleware
     */
    public function addPsr15Middleware(Psr15MiddlewareInterface $middleware): self
    {
        $this->psr15Stack->addPsr15Middleware($middleware);
        return $this;
    }

    /**
     * Add custom middleware (works in both modes)
     */
    public function addCustomMiddleware($middleware): self
    {
        if ($this->usePsr15Mode) {
            $this->psr15Stack->addMiddleware($middleware);
        } else {
            $this->customStack->add($middleware);
        }
        return $this;
    }

    /**
     * Handle PSR-7 request and return PSR-7 response
     */
    public function handlePsr7(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->usePsr15Mode) {
            return $this->psr15Stack->handle($request);
        }

        // Convert PSR-7 to array format for custom stack
        $arrayRequest = $this->psrRequestToArray($request);
        $arrayResponse = $this->customStack->handle($arrayRequest);

        // Convert back to PSR-7
        return $this->arrayToPsrResponse($arrayResponse);
    }

    /**
     * Handle array-based request (legacy compatibility)
     */
    public function handleArray(array $request): array
    {
        if ($this->usePsr15Mode) {
            // Convert array to PSR-7
            $psrRequest = new PsrRequestAdapter($request);
            $psrResponse = $this->psr15Stack->handle($psrRequest);

            // Convert PSR-7 response back to array
            return $this->psrResponseToArray($psrResponse);
        }

        return $this->customStack->handle($request);
    }

    /**
     * Get PSR-15 middleware stack
     */
    public function getPsr15Stack(): Psr15MiddlewareStack
    {
        return $this->psr15Stack;
    }

    /**
     * Get custom middleware stack
     */
    public function getCustomStack(): MiddlewareStack
    {
        return $this->customStack;
    }

    /**
     * Check if PSR-15 mode is enabled
     */
    public function isPsr15Mode(): bool
    {
        return $this->usePsr15Mode;
    }

    private function psrRequestToArray(ServerRequestInterface $request): array
    {
        return [
            'server' => $request->getServerParams(),
            'get' => $request->getQueryParams(),
            'post' => $request->getParsedBody() ?? [],
            'headers' => $request->getHeaders(),
            'attributes' => $request->getAttributes(),
            'method' => $request->getMethod(),
            'uri' => (string) $request->getUri(),
        ];
    }

    private function psrResponseToArray(ResponseInterface $response): array
    {
        return [
            'status' => $response->getStatusCode(),
            'headers' => $response->getHeaders(),
            'body' => (string) $response->getBody(),
        ];
    }

    private function arrayToPsrResponse(array $arrayResponse): ResponseInterface
    {
        $psrResponse = new PsrResponseAdapter(
            $arrayResponse['status'] ?? 200,
            '',
            $arrayResponse['headers'] ?? []
        );

        if (isset($arrayResponse['body'])) {
            $psrResponse->getBody()->write($arrayResponse['body']);
        }

        return $psrResponse;
    }
}
