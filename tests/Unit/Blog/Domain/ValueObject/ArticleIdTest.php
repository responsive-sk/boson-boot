<?php

declare(strict_types=1);

namespace Tests\Unit\Blog\Domain\ValueObject;

use Boson\Blog\Domain\ValueObject\ArticleId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ArticleIdTest extends TestCase
{
    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromInt
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::value
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::toString
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::__toString
     */
    public function testFromIntValid(): void
    {
        $id = ArticleId::fromInt(123);
        $this->assertInstanceOf(ArticleId::class, $id);
        $this->assertSame(123, $id->value());
        $this->assertSame(123, $id->toInt());
        $this->assertSame('123', $id->toString());
        $this->assertSame('123', (string) $id);
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromInt
     */
    public function testFromIntMinimum(): void
    {
        $id = ArticleId::fromInt(1);
        $this->assertSame(1, $id->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromInt
     */
    public function testFromIntZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field id must be at least 1');
        ArticleId::fromInt(0);
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromInt
     */
    public function testFromIntNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field id must be at least 1');
        ArticleId::fromInt(-1);
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromString
     */
    public function testFromStringValid(): void
    {
        $id = ArticleId::fromString('456');
        $this->assertInstanceOf(ArticleId::class, $id);
        $this->assertSame(456, $id->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromString
     */
    public function testFromStringWithSpaces(): void
    {
        $id = ArticleId::fromString('  789  ');
        $this->assertSame(789, $id->value());
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromString
     */
    public function testFromStringInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid article ID format');
        ArticleId::fromString('abc');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromString
     */
    public function testFromStringFloat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid article ID format');
        ArticleId::fromString('123.45');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::fromString
     */
    public function testFromStringZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Field id must be at least 1');
        ArticleId::fromString('0');
    }

    /**
     * @covers \Boson\Blog\Domain\ValueObject\ArticleId::equals
     */
    public function testEquals(): void
    {
        $id1 = ArticleId::fromInt(100);
        $id2 = ArticleId::fromInt(100);
        $id3 = ArticleId::fromInt(200);

        $this->assertTrue($id1->equals($id2));
        $this->assertFalse($id1->equals($id3));
        $this->assertFalse($id1->equals(null));
    }
}
