<?php

namespace App\Entity;

use App\Repository\OTVRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OTVRepository::class)]
#[ORM\HasLifecycleCallbacks]
class OTV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_Date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_Date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\Column(nullable: true)]
    private ?array $data = null;

    #[ORM\ManyToOne(inversedBy: 'oTVs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Residents $residents = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pathToFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fileName = null;

    #[ORM\Column]
    private ?bool $pending = null;

    // Ajouter les valeurs par défaut d'une OTV à la création
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        if ($this->pending === null) {
            $this->pending = true;
        }

        if ($this->created_At === null) {
            $this->created_At = new \DateTimeImmutable("now");
        }
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_Date;
    }

    public function setStartDate(\DateTimeInterface $start_Date): static
    {
        $this->start_Date = $start_Date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_Date;
    }

    public function setEndDate(\DateTimeInterface $end_Date): static
    {
        $this->end_Date = $end_Date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_At;
    }

    public function setCreatedAt(\DateTimeImmutable $created_At): static
    {
        $this->created_At = $created_At;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getResidents(): ?Residents
    {
        return $this->residents;
    }

    public function setResidents(?Residents $residents): static
    {
        $this->residents = $residents;

        return $this;
    }

    public function getPathToFile(): ?string
    {
        return $this->pathToFile;
    }

    public function setPathToFile(string $pathToFile): static
    {
        $this->pathToFile = $pathToFile;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function isPending(): ?bool
    {
        return $this->pending;
    }

    public function setPending(bool $pending): static
    {
        $this->pending = $pending;

        return $this;
    }
}
