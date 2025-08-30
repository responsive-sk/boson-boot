<?php

declare(strict_types=1);

namespace Boson\Shared\Presentation\Request;

/**
 * Pagination Request Object
 */
final class PaginationRequest
{
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_PER_PAGE = 10;
    private const MAX_PER_PAGE = 100;

    public function __construct(
        private int $page = self::DEFAULT_PAGE,
        private int $perPage = self::DEFAULT_PER_PAGE
    ) {
        $this->validatePage($page);
        $this->validatePerPage($perPage);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->perPage;
    }

    private function validatePage(int $page): void
    {
        if ($page < 1) {
            throw new \InvalidArgumentException('Page must be positive integer');
        }
    }

    private function validatePerPage(int $perPage): void
    {
        if ($perPage < 1) {
            throw new \InvalidArgumentException('Per page must be positive integer');
        }

        if ($perPage > self::MAX_PER_PAGE) {
            throw new \InvalidArgumentException(
                sprintf('Per page cannot exceed %d', self::MAX_PER_PAGE)
            );
        }
    }

    /**
     * Create from HTTP request data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            page: (int) ($data['page'] ?? self::DEFAULT_PAGE),
            perPage: (int) ($data['per_page'] ?? self::DEFAULT_PER_PAGE)
        );
    }

    /**
     * Create from global $_GET
     */
    public static function fromGlobals(): self
    {
        return self::fromArray($_GET);
    }
}
