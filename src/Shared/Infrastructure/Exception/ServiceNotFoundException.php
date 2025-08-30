<?php

declare(strict_types=1);

namespace Boson\Shared\Infrastructure\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Exception thrown when a service is not found in the container
 */
class ServiceNotFoundException extends \Exception implements NotFoundExceptionInterface
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
