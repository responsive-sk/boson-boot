<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Psr15;

use Boson\Shared\Infrastructure\Http\Middleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Psr15MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Adapter to wrap custom middlewares and make them PSR-15 compatible
 */
class Psr15MiddlewareAdapter implements Psr15MiddlewareInterface
{
    private MiddlewareInterface $customMiddleware;

    public function __construct(MiddlewareInterface $customMiddleware)
    {
        $this->customMiddleware = $customMiddleware;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Convert PSR-7 request to array format
        $arrayRequest = $this->psrRequestToArray($request);

        // Create a callable that will handle the next middleware in the chain
        $nextCallable = function (array $request) use ($handler) {
            // Convert array request back to PSR-7 for the next handler
            $psrRequest = new PsrRequestAdapter($request);
            $psrResponse = $handler->handle($psrRequest);

            // Convert PSR-7 response back to array format
            return $this->psrResponseToArray($psrResponse);
        };

        // Execute the custom middleware
        $arrayResponse = $this->customMiddleware->handle($arrayRequest, $nextCallable);

        // Convert array response back to PSR-7
        return $this->arrayToPsrResponse($arrayResponse);
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
