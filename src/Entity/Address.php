<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $streetNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $additionnalStreetNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $additionalAddressInfo = null;

    /**
     * @var Collection<int, OTV>
     */
    #[ORM\OneToMany(targetEntity: OTV::class, mappedBy: 'address')]
    private Collection $otv;

    public function __construct()
    {
        $this->otv = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): static
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getAdditionnalStreetNumber(): ?string
    {
        return $this->additionnalStreetNumber;
    }

    public function setAdditionnalStreetNumber(?string $additionnalStreetNumber): static
    {
        $this->additionnalStreetNumber = $additionnalStreetNumber;

        return $this;
    }

    public function getAdditionalAddressInfo(): ?string
    {
        return $this->additionalAddressInfo;
    }

    public function setAdditionalAddressInfo(?string $additionalAddressInfo): static
    {
        $this->additionalAddressInfo = $additionalAddressInfo;

        return $this;
    }

    /**
     * @return Collection<int, OTV>
     */
    public function getOtv(): Collection
    {
        return $this->otv;
    }

    public function addOtv(OTV $otv): static
    {
        if (!$this->otv->contains($otv)) {
            $this->otv->add($otv);
            $otv->setAddress($this);
        }

        return $this;
    }

    public function removeOtv(OTV $otv): static
    {
        if ($this->otv->removeElement($otv)) {
            // set the owning side to null (unless already changed)
            if ($otv->getAddress() === $this) {
                $otv->setAddress(null);
            }
        }

        return $this;
    }
}
