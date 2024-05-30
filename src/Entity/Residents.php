<?php

namespace App\Entity;

use App\Repository\ResidentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResidentsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Residents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $civility = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    /**
     * @var Collection<int, OTV>
     */
    #[ORM\OneToMany(targetEntity: OTV::class, mappedBy: 'residents', orphanRemoval: true)]
    private Collection $oTVs;


    public function __construct()
    {
        $this->oTVs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(?string $civility): static
    {
        $this->civility = $civility;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }


    /**
     * @return Collection<int, OTV>
     */
    public function getOTVs(): Collection
    {
        return $this->oTVs;
    }

    public function addOTV(OTV $oTV): static
    {
        if (!$this->oTVs->contains($oTV)) {
            $this->oTVs->add($oTV);
            $oTV->setResidents($this);
        }

        return $this;
    }

    public function removeOTV(OTV $oTV): static
    {
        if ($this->oTVs->removeElement($oTV)) {
            // set the owning side to null (unless already changed)
            if ($oTV->getResidents() === $this) {
                $oTV->setResidents(null);
            }
        }

        return $this;
    }


}
