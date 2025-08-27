<?php

declare(strict_types=1);

namespace Boson\Blog\Infrastructure;

use Boson\Blog\Domain\Author;
use Boson\Shared\Infrastructure\Persistence\Database;
use PDO;

class AuthorRepository
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function findById(int $id): ?Author
    {
        $sql = 'SELECT * FROM authors WHERE id = ?';
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$id]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? Author::fromArray($data) : null;
    }

    public function findByEmail(string $email): ?Author
    {
        $sql = 'SELECT * FROM authors WHERE email = ?';
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$email]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data ? Author::fromArray($data) : null;
    }

    public function findAll(): array
    {
        $sql = 'SELECT * FROM authors ORDER BY name ASC';
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return array_map(fn($data) => Author::fromArray($data), $results);
    }

    public function save(Author $author): void
    {
        $data = $author->toArray();
        
        if (isset($data['id']) && $data['id'] > 0) {
            // Update existing author
            $sql = 'UPDATE authors SET name = ?, email = ?, bio = ?, avatar = ?, updated_at = ? WHERE id = ?';
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['bio'],
                $data['avatar'],
                $data['updated_at'],
                $data['id']
            ]);
        } else {
            // Insert new author
            $sql = 'INSERT INTO authors (name, email, bio, avatar, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)';
            $stmt = $this->database->getConnection()->prepare($sql);
            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['bio'],
                $data['avatar'],
                $data['created_at'],
                $data['updated_at']
            ]);
        }
    }

    public function delete(int $id): void
    {
        $sql = 'DELETE FROM authors WHERE id = ?';
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute([$id]);
    }
}
