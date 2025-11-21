<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private array $specs = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSpecs(): array
    {
        return $this->specs;
    }

    public function setSpecs(array $specs): static
    {
        $this->specs = $specs;

        return $this;
    }

    // Virtual Properties for EasyAdmin "Getter/Setter" Approach

    public function getPageCount(): ?int
    {
        return $this->specs['page_count'] ?? null;
    }

    public function setPageCount(?int $pageCount): static
    {
        $this->specs['page_count'] = $pageCount;
        return $this;
    }

    public function getCoverType(): ?string
    {
        return $this->specs['cover_type'] ?? null;
    }

    public function setCoverType(?string $coverType): static
    {
        $this->specs['cover_type'] = $coverType;
        return $this;
    }

    public function isAvailable(): bool
    {
        return $this->specs['is_available'] ?? false;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->specs['is_available'] = $isAvailable;
        return $this;
    }
}
