<?php

namespace App\Entity;

use App\Repository\DistrictsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DistrictsRepository::class)]
class Districts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Residents>
     */
    #[ORM\OneToMany(targetEntity: Residents::class, mappedBy: 'districts')]
    private Collection $residents;

    public function __construct()
    {
        $this->residents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Residents>
     */
    public function getResidents(): Collection
    {
        return $this->residents;
    }

    public function addResident(Residents $resident): static
    {
        if (!$this->residents->contains($resident)) {
            $this->residents->add($resident);
            $resident->setDistricts($this);
        }

        return $this;
    }

    public function removeResident(Residents $resident): static
    {
        if ($this->residents->removeElement($resident)) {
            // set the owning side to null (unless already changed)
            if ($resident->getDistricts() === $this) {
                $resident->setDistricts(null);
            }
        }

        return $this;
    }
}
