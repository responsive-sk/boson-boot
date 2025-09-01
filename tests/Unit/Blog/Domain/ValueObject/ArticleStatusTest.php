<?php

declare(strict_types=1);

namespace Tests\Unit\Blog\Domain\ValueObject;

use Boson\Blog\Domain\ValueObject\ArticleStatus;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ArticleStatusTest extends TestCase
{
    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::fromString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::value
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::toString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::__toString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isDraft
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isPublished
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isArchived
     */
    public function testFromStringDraft(): void
    {
        $status = ArticleStatus::fromString('draft');
        $this->assertInstanceOf(ArticleStatus::class, $status);
        $this->assertSame('draft', $status->value());
        $this->assertSame('draft', $status->toString());
        $this->assertSame('draft', (string) $status);
        $this->assertTrue($status->isDraft());
        $this->assertFalse($status->isPublished());
        $this->assertFalse($status->isArchived());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::fromString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isPublished
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isDraft
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isArchived
     */
    public function testFromStringPublished(): void
    {
        $status = ArticleStatus::fromString('published');
        $this->assertSame('published', $status->value());
        $this->assertTrue($status->isPublished());
        $this->assertFalse($status->isDraft());
        $this->assertFalse($status->isArchived());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::fromString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isArchived
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isDraft
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::isPublished
     */
    public function testFromStringArchived(): void
    {
        $status = ArticleStatus::fromString('archived');
        $this->assertSame('archived', $status->value());
        $this->assertTrue($status->isArchived());
        $this->assertFalse($status->isDraft());
        $this->assertFalse($status->isPublished());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::fromString
     */
    public function testFromStringCaseInsensitive(): void
    {
        $status = ArticleStatus::fromString('DRAFT');
        $this->assertSame('draft', $status->value());

        $status = ArticleStatus::fromString('Published');
        $this->assertSame('published', $status->value());

        $status = ArticleStatus::fromString('ARCHIVED');
        $this->assertSame('archived', $status->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::fromString
     */
    public function testFromStringWithWhitespace(): void
    {
        $status = ArticleStatus::fromString('  draft  ');
        $this->assertSame('draft', $status->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::fromString
     */
    public function testFromStringInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field status must be one of: draft, published, archived');
        ArticleStatus::fromString('invalid');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::fromString
     */
    public function testFromStringEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field status is required');
        ArticleStatus::fromString('');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::fromString
     */
    public function testFromStringWhitespaceOnly(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field status is required');
        ArticleStatus::fromString('   ');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::equals
     */
    public function testEquals(): void
    {
        $status1 = ArticleStatus::fromString('draft');
        $status2 = ArticleStatus::fromString('draft');
        $status3 = ArticleStatus::fromString('published');

        $this->assertTrue($status1->equals($status2));
        $this->assertFalse($status1->equals($status3));
        $this->assertFalse($status1->equals(null));
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::DRAFT
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::PUBLISHED
     * @covers \Boson\Blog\Domain\ValueObject\ArticleStatus::ARCHIVED
     */
    public function testConstants(): void
    {
        $this->assertSame('draft', ArticleStatus::DRAFT);
        $this->assertSame('published', ArticleStatus::PUBLISHED);
        $this->assertSame('archived', ArticleStatus::ARCHIVED);
    }
}
