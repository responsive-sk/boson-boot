<?php

declare(strict_types=1);

namespace Tests\Unit\Blog\Domain\ValueObject;

use Boson\Blog\Domain\ValueObject\ArticleTitle;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ArticleTitleTest extends TestCase
{
    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::fromString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::value
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::toString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::__toString
     */
    public function testFromStringValid(): void
    {
        $title = ArticleTitle::fromString('Valid Title');
        $this->assertInstanceOf(ArticleTitle::class, $title);
        $this->assertSame('Valid Title', $title->value());
        $this->assertSame('Valid Title', $title->toString());
        $this->assertSame('Valid Title', (string) $title);
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::fromString
     */
    public function testFromStringWithWhitespace(): void
    {
        $title = ArticleTitle::fromString('  Title with spaces  ');
        $this->assertSame('Title with spaces', $title->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::fromString
     */
    public function testFromStringMinimumLength(): void
    {
        $title = ArticleTitle::fromString('ABC');
        $this->assertSame('ABC', $title->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::fromString
     */
    public function testFromStringMaximumLength(): void
    {
        $longTitle = str_repeat('A', 255);
        $title = ArticleTitle::fromString($longTitle);
        $this->assertSame($longTitle, $title->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::fromString
     */
    public function testFromStringEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field title is required');
        ArticleTitle::fromString('');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::fromString
     */
    public function testFromStringWhitespaceOnly(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field title is required');
        ArticleTitle::fromString('   ');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::fromString
     */
    public function testFromStringTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field title must be at least 3 characters');
        ArticleTitle::fromString('AB');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::fromString
     */
    public function testFromStringTooLong(): void
    {
        $longTitle = str_repeat('A', 256);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field title must not exceed 255 characters');
        ArticleTitle::fromString($longTitle);
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleTitle::equals
     */
    public function testEquals(): void
    {
        $title1 = ArticleTitle::fromString('Test Title');
        $title2 = ArticleTitle::fromString('Test Title');
        $title3 = ArticleTitle::fromString('Different Title');

        $this->assertTrue($title1->equals($title2));
        $this->assertFalse($title1->equals($title3));
        $this->assertFalse($title1->equals(null));
    }
}
