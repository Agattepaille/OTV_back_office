<?php

namespace App\Entity;

use App\Repository\DistrictsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DistrictsRepository::class)]
#[ORM\HasLifecycleCallbacks]
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

    /**
     * @var Collection<int, OTV>
     */
    #[ORM\OneToMany(targetEntity: OTV::class, mappedBy: 'district')]
    private Collection $OTVs;

    public function __construct()
    {
        $this->residents = new ArrayCollection();
        $this->OTVs = new ArrayCollection();
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

    /**
     * @return Collection<int, OTV>
     */
    public function getOTVs(): Collection
    {
        return $this->OTVs;
    }

    public function addOTV(OTV $oTV): static
    {
        if (!$this->OTVs->contains($oTV)) {
            $this->OTVs->add($oTV);
            $oTV->setDistrict($this);
        }

        return $this;
    }

    public function removeOTV(OTV $oTV): static
    {
        if ($this->OTVs->removeElement($oTV)) {
            // set the owning side to null (unless already changed)
            if ($oTV->getDistrict() === $this) {
                $oTV->setDistrict(null);
            }
        }

        return $this;
    }
}
