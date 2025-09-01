<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Psr15;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Adapter to convert array-based request to PSR-7 ServerRequestInterface
 */
class PsrRequestAdapter implements ServerRequestInterface
{
    private array $serverParams;
    private array $queryParams;
    private array $parsedBody;
    private array $attributes = [];
    private array $headers = [];

    public function __construct(array $request)
    {
        $this->serverParams = $request['server'] ?? [];
        $this->queryParams = $request['get'] ?? [];
        $this->parsedBody = $request['post'] ?? [];
        $this->headers = $request['headers'] ?? [];
        $this->attributes = $request['attributes'] ?? [];
    }

    public function getProtocolVersion(): string
    {
        return '1.1';
    }

    public function withProtocolVersion(string $version): ServerRequestInterface
    {
        // For simplicity, return self since we don't modify protocol version
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader(string $name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    public function getHeader(string $name): array
    {
        $name = strtolower($name);
        return $this->headers[$name] ?? [];
    }

    public function getHeaderLine(string $name): string
    {
        return implode(', ', $this->getHeader($name));
    }

    public function withHeader(string $name, $value): ServerRequestInterface
    {
        $clone = clone $this;
        $clone->headers[strtolower($name)] = is_array($value) ? $value : [$value];
        return $clone;
    }

    public function withAddedHeader(string $name, $value): ServerRequestInterface
    {
        $clone = clone $this;
        $name = strtolower($name);
        if (!isset($clone->headers[$name])) {
            $clone->headers[$name] = [];
        }
        $clone->headers[$name] = array_merge($clone->headers[$name], is_array($value) ? $value : [$value]);
        return $clone;
    }

    public function withoutHeader(string $name): ServerRequestInterface
    {
        $clone = clone $this;
        unset($clone->headers[strtolower($name)]);
        return $clone;
    }

    public function getBody(): StreamInterface
    {
        // Return a simple stream implementation
        return new class implements StreamInterface {
            public function __toString(): string { return ''; }
            public function close(): void {}
            public function detach() { return null; }
            public function getSize(): ?int { return 0; }
            public function tell(): int { return 0; }
            public function eof(): bool { return true; }
            public function isSeekable(): bool { return false; }
            public function seek(int $offset, int $whence = SEEK_SET): void {}
            public function rewind(): void {}
            public function isWritable(): bool { return false; }
            public function write(string $string): int { return 0; }
            public function isReadable(): bool { return false; }
            public function read(int $length): string { return ''; }
            public function getContents(): string { return ''; }
            public function getMetadata(?string $key = null) { return null; }
        };
    }

    public function withBody(StreamInterface $body): ServerRequestInterface
    {
        return $this; // For simplicity
    }

    public function getRequestTarget(): string
    {
        return $this->serverParams['REQUEST_URI'] ?? '/';
    }

    public function withRequestTarget(string $requestTarget): ServerRequestInterface
    {
        return $this; // For simplicity
    }

    public function getMethod(): string
    {
        return $this->serverParams['REQUEST_METHOD'] ?? 'GET';
    }

    public function withMethod(string $method): ServerRequestInterface
    {
        return $this; // For simplicity
    }

    public function getUri(): UriInterface
    {
        return new class($this->getRequestTarget()) implements UriInterface {
            private string $uri;

            public function __construct(string $uri) {
                $this->uri = $uri;
            }

            public function getScheme(): string { return 'http'; }
            public function getAuthority(): string { return ''; }
            public function getUserInfo(): string { return ''; }
            public function getHost(): string { return ''; }
            public function getPort(): ?int { return null; }
            public function getPath(): string { return $this->uri; }
            public function getQuery(): string { return ''; }
            public function getFragment(): string { return ''; }
            public function withScheme(string $scheme): UriInterface { return $this; }
            public function withUserInfo(string $user, ?string $password = null): UriInterface { return $this; }
            public function withHost(string $host): UriInterface { return $this; }
            public function withPort(?int $port): UriInterface { return $this; }
            public function withPath(string $path): UriInterface { return $this; }
            public function withQuery(string $query): UriInterface { return $this; }
            public function withFragment(string $fragment): UriInterface { return $this; }
            public function __toString(): string { return $this->uri; }
        };
    }

    public function withUri(UriInterface $uri, bool $preserveHost = false): ServerRequestInterface
    {
        return $this; // For simplicity
    }

    public function getServerParams(): array
    {
        return $this->serverParams;
    }

    public function getCookieParams(): array
    {
        return []; // Not implemented for simplicity
    }

    public function withCookieParams(array $cookies): ServerRequestInterface
    {
        return $this; // For simplicity
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams(array $query): ServerRequestInterface
    {
        $clone = clone $this;
        $clone->queryParams = $query;
        return $clone;
    }

    public function getUploadedFiles(): array
    {
        return []; // Not implemented for simplicity
    }

    public function withUploadedFiles(array $uploadedFiles): ServerRequestInterface
    {
        return $this; // For simplicity
    }

    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    public function withParsedBody($data): ServerRequestInterface
    {
        $clone = clone $this;
        $clone->parsedBody = $data;
        return $clone;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    public function withAttribute(string $name, $value): ServerRequestInterface
    {
        $clone = clone $this;
        $clone->attributes[$name] = $value;
        return $clone;
    }

    public function withoutAttribute(string $name): ServerRequestInterface
    {
        $clone = clone $this;
        unset($clone->attributes[$name]);
        return $clone;
    }
}
