<?php

declare(strict_types=1);

namespace Tests\Unit\Blog\Domain\ValueObject;

use Boson\Blog\Domain\ValueObject\ArticleContent;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ArticleContentTest extends TestCase
{
    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::fromString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::value
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::toString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::__toString
     */
    public function testFromStringValid(): void
    {
        $content = ArticleContent::fromString('This is a valid content with enough length.');
        $this->assertInstanceOf(ArticleContent::class, $content);
        $this->assertSame('This is a valid content with enough length.', $content->value());
        $this->assertSame('This is a valid content with enough length.', $content->toString());
        $this->assertSame('This is a valid content with enough length.', (string) $content);
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::fromString
     */
    public function testFromStringWithWhitespace(): void
    {
        $content = ArticleContent::fromString('  Content with spaces  ');
        $this->assertSame('Content with spaces', $content->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::fromString
     */
    public function testFromStringMinimumLength(): void
    {
        $content = ArticleContent::fromString('1234567890'); // exactly 10 chars
        $this->assertSame('1234567890', $content->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::fromString
     */
    public function testFromStringMaximumLength(): void
    {
        $longContent = str_repeat('A', 10000);
        $content = ArticleContent::fromString($longContent);
        $this->assertSame($longContent, $content->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::fromString
     */
    public function testFromStringEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field content is required');
        ArticleContent::fromString('');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::fromString
     */
    public function testFromStringWhitespaceOnly(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field content is required');
        ArticleContent::fromString('   ');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::fromString
     */
    public function testFromStringTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field content must be at least 10 characters');
        ArticleContent::fromString('Short');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::fromString
     */
    public function testFromStringTooLong(): void
    {
        $longContent = str_repeat('A', 10001);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field content must not exceed 10000 characters');
        ArticleContent::fromString($longContent);
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleContent::equals
     */
    public function testEquals(): void
    {
        $content1 = ArticleContent::fromString('Test content with enough length.');
        $content2 = ArticleContent::fromString('Test content with enough length.');
        $content3 = ArticleContent::fromString('Different content with enough length.');

        $this->assertTrue($content1->equals($content2));
        $this->assertFalse($content1->equals($content3));
        $this->assertFalse($content1->equals(null));
    }
}
