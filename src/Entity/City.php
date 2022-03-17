<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $zipcode;

    /**
     * @ORM\OneToMany(targetEntity=Uer::class, mappedBy="city", orphanRemoval=true)
     */
    private $uers;

    public function __construct()
    {
        $this->uers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * @return Collection<int, Uer>
     */
    public function getUers(): Collection
    {
        return $this->uers;
    }

    public function addUer(Uer $uer): self
    {
        if (!$this->uers->contains($uer)) {
            $this->uers[] = $uer;
            $uer->setCity($this);
        }

        return $this;
    }

    public function removeUer(Uer $uer): self
    {
        if ($this->uers->removeElement($uer)) {
            // set the owning side to null (unless already changed)
            if ($uer->getCity() === $this) {
                $uer->setCity(null);
            }
        }

        return $this;
    }
}
