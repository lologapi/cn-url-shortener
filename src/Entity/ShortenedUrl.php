<?php

namespace App\Entity;

use DateTime;
use Ramsey\Uuid\Uuid;

final readonly class ShortenedUrl
{
    public function __construct(
        private string $id,
        private string $shortCode,
        private string $originalUrl,
        private DateTime $createdAt,
        private DateTime $updatedAt,
        private ?DateTime $deletedAt,
    )
    {
    }

    public static function create(string $shortCode, string $originalUrl): self
    {
        $now = new DateTime();

        return new self(
            Uuid::uuid4()->toString(),
            $shortCode,
            $originalUrl,
            $now,
            $now,
            null
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function shortCode(): string
    {
        return $this->shortCode;
    }

    public function originalUrl(): string
    {
        return $this->originalUrl;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }
}
