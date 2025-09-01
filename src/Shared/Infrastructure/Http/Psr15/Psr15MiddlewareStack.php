<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Psr15;

use Boson\Shared\Infrastructure\Http\Middleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Psr15MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * PSR-15 compatible middleware stack that supports both PSR-15 and custom middlewares
 */
class Psr15MiddlewareStack implements RequestHandlerInterface
{
    /** @var array<Psr15MiddlewareInterface|MiddlewareInterface> */
    private array $middlewares = [];
    private RequestHandlerInterface $finalHandler;

    public function __construct(RequestHandlerInterface $finalHandler)
    {
        $this->finalHandler = $finalHandler;
    }

    /**
     * Add a PSR-15 middleware
     */
    public function addPsr15Middleware(Psr15MiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * Add a custom middleware (will be wrapped in adapter)
     */
    public function addCustomMiddleware(MiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * Add any middleware (PSR-15 or custom)
     */
    public function addMiddleware($middleware): self
    {
        if ($middleware instanceof Psr15MiddlewareInterface) {
            return $this->addPsr15Middleware($middleware);
        } elseif ($middleware instanceof MiddlewareInterface) {
            return $this->addCustomMiddleware($middleware);
        }

        throw new \InvalidArgumentException('Middleware must implement PSR-15 MiddlewareInterface or custom MiddlewareInterface');
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (empty($this->middlewares)) {
            return $this->finalHandler->handle($request);
        }

        // Create a handler chain from the middlewares
        $handler = $this->createHandlerChain();

        return $handler->handle($request);
    }

    private function createHandlerChain(): RequestHandlerInterface
    {
        $middlewares = array_reverse($this->middlewares); // Reverse to process in correct order

        $handler = $this->finalHandler;

        foreach ($middlewares as $middleware) {
            if ($middleware instanceof Psr15MiddlewareInterface) {
                $handler = new class($middleware, $handler) implements RequestHandlerInterface {
                    private Psr15MiddlewareInterface $middleware;
                    private RequestHandlerInterface $next;

                    public function __construct(Psr15MiddlewareInterface $middleware, RequestHandlerInterface $next)
                    {
                        $this->middleware = $middleware;
                        $this->next = $next;
                    }

                    public function handle(ServerRequestInterface $request): ResponseInterface
                    {
                        return $this->middleware->process($request, $this->next);
                    }
                };
            } elseif ($middleware instanceof MiddlewareInterface) {
                // Wrap custom middleware in PSR-15 adapter
                $psr15Adapter = new Psr15MiddlewareAdapter($middleware);
                $handler = new class($psr15Adapter, $handler) implements RequestHandlerInterface {
                    private Psr15MiddlewareInterface $middleware;
                    private RequestHandlerInterface $next;

                    public function __construct(Psr15MiddlewareInterface $middleware, RequestHandlerInterface $next)
                    {
                        $this->middleware = $middleware;
                        $this->next = $next;
                    }

                    public function handle(ServerRequestInterface $request): ResponseInterface
                    {
                        return $this->middleware->process($request, $this->next);
                    }
                };
            }
        }

        return $handler;
    }

    /**
     * Get all registered middlewares
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * Clear all middlewares
     */
    public function clear(): self
    {
        $this->middlewares = [];
        return $this;
    }
}
