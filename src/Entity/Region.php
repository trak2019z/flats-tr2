<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\City", mappedBy="region")
     */
    private $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
            $city->setRegion($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->contains($city)) {
            $this->cities->removeElement($city);
            // set the owning side to null (unless already changed)
            if ($city->getRegion() === $this) {
                $city->setRegion(null);
            }
        }

        return $this;
    }

    public function getMainCities()
    {
        $criteria = new Criteria();
        $criteria->andWhere(Criteria::expr()->eq('village', false));
        $criteria->orderBy(['name'=>'asc']);

        return $this->cities->matching($criteria);
    }

    public function getRegionCenter()
    {
        $criteria = new Criteria();
        $criteria->orderBy(['lat'=>'asc']);
        $criteria->setMaxResults(1);
        $minLat = $this->cities->matching($criteria)->first()->getLat();
        $criteria = new Criteria();
        $criteria->orderBy(['lon'=>'asc']);
        $criteria->setMaxResults(1);
        $minLon = $this->cities->matching($criteria)->first()->getLon();
        $criteria = new Criteria();
        $criteria->orderBy(['lat'=>'desc']);
        $criteria->setMaxResults(1);
        $maxLat = $this->cities->matching($criteria)->first()->getLat();
        $criteria->orderBy(['lon'=>'desc']);
        $criteria->setMaxResults(1);
        $maxLon = $this->cities->matching($criteria)->first()->getLon();

        return [($maxLat+$minLat)/2,($maxLon+$minLon)/2];
    }
}
