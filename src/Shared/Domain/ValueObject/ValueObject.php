<?php

declare(strict_types=1);

namespace Boson\Shared\Domain\ValueObject;

/**
 * Base interface for all Value Objects
 */
interface ValueObject
{
    /**
     * Check if this value object equals another
     */
    public function equals(ValueObject $other): bool;

    /**
     * Get the primitive value
     */
    public function value(): mixed;

    /**
     * String representation
     */
    public function __toString(): string;
}
