<?php

namespace App\Entity;

use App\Repository\MicroPostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MicroPostRepository::class)]
class MicroPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /* because these (title and text) don't have a nullable param, symfony assumes they are required fields 
    which means their input fields on an html form will automatically have the required attr added */
    #[ORM\Column(length: 255)]
    // basically calls the Assert (validator) obj and calls its NotBlank() method
    #[Assert\NotBlank()]
    // calls the Length() method to check for input length 
    #[Assert\Length(min: 1, max: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    #[Assert\Length(min: 1, max: 500, maxMessage: 'Please limit your post text to fewer than 500 characters.')]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }
}
