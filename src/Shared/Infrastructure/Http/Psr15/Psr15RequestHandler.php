<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Psr15;

use Boson\Shared\Infrastructure\Http\RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * PSR-15 compatible request handler that wraps the existing RequestHandler
 */
class Psr15RequestHandler implements RequestHandlerInterface
{
    private RequestHandler $originalHandler;

    public function __construct(RequestHandler $originalHandler)
    {
        $this->originalHandler = $originalHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Convert PSR-7 request to array format
        $arrayRequest = $this->psrRequestToArray($request);

        // Handle the request using the original handler
        $arrayResponse = $this->originalHandler->handle($arrayRequest);

        // Convert array response to PSR-7
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
