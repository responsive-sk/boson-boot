<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Http\Psr15;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Adapter to convert PSR-7 ResponseInterface to array-based response
 */
class PsrResponseAdapter implements ResponseInterface
{
    private int $statusCode;
    private string $reasonPhrase;
    private array $headers = [];
    private ?StreamInterface $body = null;

    public function __construct(int $statusCode = 200, string $reasonPhrase = '', array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        $this->headers = $headers;
    }

    public function getProtocolVersion(): string
    {
        return '1.1';
    }

    public function withProtocolVersion(string $version): ResponseInterface
    {
        $clone = clone $this;
        return $clone;
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

    public function withHeader(string $name, $value): ResponseInterface
    {
        $clone = clone $this;
        $clone->headers[strtolower($name)] = is_array($value) ? $value : [$value];
        return $clone;
    }

    public function withAddedHeader(string $name, $value): ResponseInterface
    {
        $clone = clone $this;
        $name = strtolower($name);
        if (!isset($clone->headers[$name])) {
            $clone->headers[$name] = [];
        }
        $clone->headers[$name] = array_merge($clone->headers[$name], is_array($value) ? $value : [$value]);
        return $clone;
    }

    public function withoutHeader(string $name): ResponseInterface
    {
        $clone = clone $this;
        unset($clone->headers[strtolower($name)]);
        return $clone;
    }

    public function getBody(): StreamInterface
    {
        if ($this->body === null) {
            $this->body = new class implements StreamInterface {
                private string $content = '';

                public function __toString(): string {
                    return $this->content;
                }

                public function close(): void {}
                public function detach() { return null; }
                public function getSize(): ?int { return strlen($this->content); }
                public function tell(): int { return 0; }
                public function eof(): bool { return true; }
                public function isSeekable(): bool { return false; }
                public function seek(int $offset, int $whence = SEEK_SET): void {}
                public function rewind(): void {}
                public function isWritable(): bool { return true; }
                public function write(string $string): int {
                    $this->content .= $string;
                    return strlen($string);
                }
                public function isReadable(): bool { return true; }
                public function read(int $length): string {
                    return substr($this->content, 0, $length);
                }
                public function getContents(): string {
                    return $this->content;
                }
                public function getMetadata(?string $key = null) {
                    return null;
                }
            };
        }
        return $this->body;
    }

    public function withBody(StreamInterface $body): ResponseInterface
    {
        $clone = clone $this;
        $clone->body = $body;
        return $clone;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        $clone = clone $this;
        $clone->statusCode = $code;
        $clone->reasonPhrase = $reasonPhrase;
        return $clone;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * Convert PSR-7 Response to array format
     */
    public function toArrayResponse(): array
    {
        $body = '';
        if ($this->body !== null) {
            $body = (string) $this->body;
        }

        return [
            'status' => $this->statusCode,
            'headers' => $this->headers,
            'body' => $body,
        ];
    }
}
