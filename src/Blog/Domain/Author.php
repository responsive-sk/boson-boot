<?php

declare(strict_types=1);

namespace Boson\Blog\Domain;

use DateTimeImmutable;

class Author
{
    private int $id;
    private string $name;
    private string $email;
    private ?string $bio;
    private ?string $avatar;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    private function __construct(
        string $name,
        string $email,
        ?string $bio = null,
        ?string $avatar = null
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->bio = $bio;
        $this->avatar = $avatar;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public static function create(
        string $name,
        string $email,
        ?string $bio = null,
        ?string $avatar = null
    ): self {
        return new self(
            name: $name,
            email: $email,
            bio: $bio,
            avatar: $avatar
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateProfile(string $name, ?string $bio = null, ?string $avatar = null): void
    {
        $this->name = $name;
        $this->bio = $bio;
        $this->avatar = $avatar;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            'avatar' => $this->avatar,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromArray(array $data): self
    {
        $author = new self(
            name: $data['name'],
            email: $data['email'],
            bio: $data['bio'] ?? null,
            avatar: $data['avatar'] ?? null
        );

        $author->id = (int) $data['id'];
        $author->createdAt = new DateTimeImmutable($data['created_at']);
        $author->updatedAt = new DateTimeImmutable($data['updated_at']);

        return $author;
    }
}
