<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure\Security;

use Boson\Shared\Infrastructure\Security\InputValidator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class InputValidatorTest extends TestCase
{
    private InputValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new InputValidator();
    }

    public function testRequiredValidation(): void
    {
        $data  = ['name' => 'John'];
        $rules = ['name' => ['required']];

        self::assertTrue($this->validator->validate($data, $rules));
        self::assertEmpty($this->validator->getErrors());
    }

    public function testRequiredValidationFails(): void
    {
        $data  = ['name' => ''];
        $rules = ['name' => ['required']];

        self::assertFalse($this->validator->validate($data, $rules));
        self::assertNotEmpty($this->validator->getErrors());
        self::assertArrayHasKey('name', $this->validator->getErrors());
    }

    public function testEmailValidation(): void
    {
        $data  = ['email' => 'test@example.com'];
        $rules = ['email' => ['email']];

        self::assertTrue($this->validator->validate($data, $rules));
    }

    public function testEmailValidationFails(): void
    {
        $data  = ['email' => 'invalid-email'];
        $rules = ['email' => ['email']];

        self::assertFalse($this->validator->validate($data, $rules));
        self::assertArrayHasKey('email', $this->validator->getErrors());
    }

    public function testMinLengthValidation(): void
    {
        $data  = ['password' => 'password123'];
        $rules = ['password' => [['min', 8]]];

        self::assertTrue($this->validator->validate($data, $rules));
    }

    public function testMinLengthValidationFails(): void
    {
        $data  = ['password' => '123'];
        $rules = ['password' => [['min', 8]]];

        self::assertFalse($this->validator->validate($data, $rules));
        self::assertArrayHasKey('password', $this->validator->getErrors());
    }

    public function testMaxLengthValidation(): void
    {
        $data  = ['title' => 'Short title'];
        $rules = ['title' => [['max', 100]]];

        self::assertTrue($this->validator->validate($data, $rules));
    }

    public function testMaxLengthValidationFails(): void
    {
        $data  = ['title' => str_repeat('a', 101)];
        $rules = ['title' => [['max', 100]]];

        self::assertFalse($this->validator->validate($data, $rules));
        self::assertArrayHasKey('title', $this->validator->getErrors());
    }

    public function testIntegerValidation(): void
    {
        $data  = ['age' => '25'];
        $rules = ['age' => ['integer']];

        self::assertTrue($this->validator->validate($data, $rules));
    }

    public function testIntegerValidationFails(): void
    {
        $data  = ['age' => 'not-a-number'];
        $rules = ['age' => ['integer']];

        self::assertFalse($this->validator->validate($data, $rules));
        self::assertArrayHasKey('age', $this->validator->getErrors());
    }

    public function testSlugValidation(): void
    {
        $data  = ['slug' => 'valid-slug-123'];
        $rules = ['slug' => ['slug']];

        self::assertTrue($this->validator->validate($data, $rules));
    }

    public function testSlugValidationFails(): void
    {
        $data  = ['slug' => 'Invalid Slug!'];
        $rules = ['slug' => ['slug']];

        self::assertFalse($this->validator->validate($data, $rules));
        self::assertArrayHasKey('slug', $this->validator->getErrors());
    }

    public function testInValidation(): void
    {
        $data  = ['status' => 'published'];
        $rules = ['status' => [['in', 'draft', 'published', 'archived']]];

        self::assertTrue($this->validator->validate($data, $rules));
    }

    public function testInValidationFails(): void
    {
        $data  = ['status' => 'invalid-status'];
        $rules = ['status' => [['in', 'draft', 'published', 'archived']]];

        self::assertFalse($this->validator->validate($data, $rules));
        self::assertArrayHasKey('status', $this->validator->getErrors());
    }

    public function testMultipleRules(): void
    {
        $data = [
            'email'    => 'test@example.com',
            'password' => 'password123',
            'name'     => 'John Doe',
        ];
        $rules = [
            'email'    => ['required', 'email'],
            'password' => ['required', ['min', 8]],
            'name'     => ['required', 'string', ['max', 100]],
        ];

        self::assertTrue($this->validator->validate($data, $rules));
        self::assertEmpty($this->validator->getErrors());
    }

    public function testMultipleRulesWithErrors(): void
    {
        $data = [
            'email'    => 'invalid-email',
            'password' => '123',
            'name'     => '',
        ];
        $rules = [
            'email'    => ['required', 'email'],
            'password' => ['required', ['min', 8]],
            'name'     => ['required', 'string'],
        ];

        self::assertFalse($this->validator->validate($data, $rules));
        $errors = $this->validator->getErrors();

        self::assertArrayHasKey('email', $errors);
        self::assertArrayHasKey('password', $errors);
        self::assertArrayHasKey('name', $errors);
    }

    public function testSanitizeString(): void
    {
        $input     = '<script>alert("xss")</script>Hello World';
        $sanitized = InputValidator::sanitizeString($input);

        self::assertStringNotContainsString('<script>', $sanitized);
        self::assertStringContainsString('Hello World', $sanitized);
    }

    public function testSanitizeEmail(): void
    {
        $input     = '  test@example.com  ';
        $sanitized = InputValidator::sanitizeEmail($input);

        self::assertSame('test@example.com', $sanitized);
    }

    public function testSanitizeInt(): void
    {
        $input     = '123abc';
        $sanitized = InputValidator::sanitizeInt($input);

        self::assertSame(123, $sanitized);
    }

    public function testStripTags(): void
    {
        $input     = '<p>Hello <strong>World</strong></p>';
        $sanitized = InputValidator::stripTags($input);

        self::assertSame('Hello World', $sanitized);
    }

    public function testStripTagsWithAllowedTags(): void
    {
        $input     = '<p>Hello <strong>World</strong> <script>alert("xss")</script></p>';
        $sanitized = InputValidator::stripTags($input, '<p><strong>');

        self::assertSame('<p>Hello <strong>World</strong> alert("xss")</p>', $sanitized);
    }

    public function testEscapeHtml(): void
    {
        $input   = '<script>alert("xss")</script>';
        $escaped = InputValidator::escapeHtml($input);

        self::assertStringContainsString('&lt;script&gt;', $escaped);
        self::assertStringNotContainsString('<script>', $escaped);
    }

    public function testGetFirstError(): void
    {
        $data  = ['name' => ''];
        $rules = ['name' => ['required']];

        $this->validator->validate($data, $rules);
        $firstError = $this->validator->getFirstError();

        self::assertIsString($firstError);
        self::assertStringContainsString('required', $firstError);
    }

    public function testGetFirstErrorWhenNoErrors(): void
    {
        $data  = ['name' => 'John'];
        $rules = ['name' => ['required']];

        $this->validator->validate($data, $rules);
        $firstError = $this->validator->getFirstError();

        self::assertNull($firstError);
    }
}
