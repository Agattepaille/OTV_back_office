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

    #[ORM\Column(length: 255)]
    private ?string $mobilePhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $landlinePhone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $streetNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $additionalStreetNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $additionalAddressInfo = null;

    /**
     * @var Collection<int, OTV>
     */
    #[ORM\OneToMany(targetEntity: OTV::class, mappedBy: 'residents', orphanRemoval: true)]
    private Collection $oTVs;

    #[ORM\ManyToOne(inversedBy: 'residents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Districts $districts = null;


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

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(string $mobilePhone): static
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    public function getLandlinePhone(): ?string
    {
        return $this->landlinePhone;
    }

    public function setLandlinePhone(?string $landlinePhone): static
    {
        $this->landlinePhone = $landlinePhone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
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

    public function getAdditionalStreetNumber(): ?string
    {
        return $this->additionalStreetNumber;
    }

    public function setAdditionalStreetNumber(?string $additionalStreetNumber): static
    {
        $this->additionalStreetNumber = $additionalStreetNumber;

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

    public function getDistricts(): ?Districts
    {
        return $this->districts;
    }

    public function setDistricts(?Districts $districts): static
    {
        $this->districts = $districts;

        return $this;
    }

}
