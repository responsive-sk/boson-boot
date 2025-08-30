<?php

declare(strict_types=1);

namespace Boson\Blog\Domain;

enum ArticleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}
