<?php

declare(strict_types=1);

namespace Boson\Blog\Domain;

enum BlogPostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::ARCHIVED => 'Archived'
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::PUBLISHED => 'green',
            self::ARCHIVED => 'red'
        };
    }

    public function canTransitionTo(BlogPostStatus $status): bool
    {
        return match ([$this, $status]) {
            [self::DRAFT, self::PUBLISHED] => true,
            [self::DRAFT, self::ARCHIVED] => true,
            [self::PUBLISHED, self::DRAFT] => true,
            [self::PUBLISHED, self::ARCHIVED] => true,
            [self::ARCHIVED, self::DRAFT] => true,
            default => false
        };
    }
}
