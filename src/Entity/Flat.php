<?php

namespace App\Entity;

use App\Helpers\Helpers;
use App\Helpers\Slugs;
use App\Validator\FlatPhoto;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlatRepository")
 */
class Flat
{
    const PHOTO_WEB_PATH = '/uploads/photos/';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleCanonical;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=20)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionCanonical;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value=-90)
     * @Assert\LessThanOrEqual(value=90)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value=-180)
     * @Assert\LessThan(value=180)
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FlatType", inversedBy="flats")
     */
    private $flatType;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\GreaterThan(value=0)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BuildingType", inversedBy="flats")
     */
    private $buildingType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=-5)
     * @Assert\LessThanOrEqual(value=20)
     */
    private $floor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThan(value=1900)
     * @Assert\LessThan(value=2020)
     */
    private $constructionYear;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=-5)
     * @Assert\LessThanOrEqual(value=20)
     */
    private $floors;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $freeFrom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\HeatingType", inversedBy="flats")
     */
    private $heatingType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\KitchenType", inversedBy="flats")
     */
    private $kitchenType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BathroomType", inversedBy="flats")
     */
    private $bathroomType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $internet;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThan(value=0)
     */
    private $internetBandwidth;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WindowsType", inversedBy="flats")
     */
    private $windowsType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="flat", cascade={"persist","remove"})
     */
    private $rooms;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipment", inversedBy="flats", cascade={"persist","remove"})
     */
    private $equipment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\FlatPreference", inversedBy="flats", cascade={"persist","remove"})
     */
    private $preferences;

    /**
     * @ORM\Column(type="array")
     * @FlatPhoto()
     */
    private $photos = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^\d{9}$/")
     */
    private $phone1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(pattern="/^\d{9}$/")
     */
    private $phone2;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FurnitureType", inversedBy="flats")
     */
    private $furnishings;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="flats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="flats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->rooms = new ArrayCollection();
        $this->equipment = new ArrayCollection();
        $this->preferences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->setTitleCanonical(Slugs::create($title,' '));

        return $this;
    }

    public function getTitleCanonical(): ?string
    {
        return $this->titleCanonical;
    }

    public function setTitleCanonical(string $titleCanonical): self
    {
        $this->titleCanonical = $titleCanonical;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        $this->setDescriptionCanonical(Slugs::create($description,' '));

        return $this;
    }

    public function getDescriptionCanonical(): ?string
    {
        return $this->descriptionCanonical;
    }

    public function setDescriptionCanonical(string $descriptionCanonical): self
    {
        $this->descriptionCanonical = $descriptionCanonical;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getFlatType(): ?FlatType
    {
        return $this->flatType;
    }

    public function setFlatType(?FlatType $flatType): self
    {
        $this->flatType = $flatType;

        return $this;
    }

    public function getArea(): ?float
    {
        return $this->area;
    }

    public function setArea(?float $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getBuildingType(): ?BuildingType
    {
        return $this->buildingType;
    }

    public function setBuildingType(?BuildingType $buildingType): self
    {
        $this->buildingType = $buildingType;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(?int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getConstructionYear(): ?int
    {
        return $this->constructionYear;
    }

    public function setConstructionYear(?int $constructionYear): self
    {
        $this->constructionYear = $constructionYear;

        return $this;
    }

    public function getFloors(): ?int
    {
        return $this->floors;
    }

    public function setFloors(?int $floors): self
    {
        $this->floors = $floors;

        return $this;
    }

    public function getFreeFrom(): ?\DateTimeInterface
    {
        return $this->freeFrom;
    }

    public function setFreeFrom(?\DateTimeInterface $freeFrom): self
    {
        $this->freeFrom = $freeFrom;

        return $this;
    }

    public function getHeatingType(): ?HeatingType
    {
        return $this->heatingType;
    }

    public function setHeatingType(?HeatingType $heatingType): self
    {
        $this->heatingType = $heatingType;

        return $this;
    }

    public function getKitchenType(): ?KitchenType
    {
        return $this->kitchenType;
    }

    public function setKitchenType(?KitchenType $kitchenType): self
    {
        $this->kitchenType = $kitchenType;

        return $this;
    }

    public function getBathroomType(): ?BathroomType
    {
        return $this->bathroomType;
    }

    public function setBathroomType(?BathroomType $bathroomType): self
    {
        $this->bathroomType = $bathroomType;

        return $this;
    }

    public function getInternet(): ?bool
    {
        return $this->internet;
    }

    public function setInternet(?bool $internet): self
    {
        $this->internet = $internet;

        return $this;
    }

    public function getInternetBandwidth(): ?int
    {
        return $this->internetBandwidth;
    }

    public function setInternetBandwidth(?int $internetBandwidth): self
    {
        $this->internetBandwidth = $internetBandwidth;

        return $this;
    }

    public function getWindowsType(): ?WindowsType
    {
        return $this->windowsType;
    }

    public function setWindowsType(?WindowsType $windowsType): self
    {
        $this->windowsType = $windowsType;

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->setFlat($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->contains($room)) {
            $this->rooms->removeElement($room);
            // set the owning side to null (unless already changed)
            if ($room->getFlat() === $this) {
                $room->setFlat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Equipment[]
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment[] = $equipment;
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->contains($equipment)) {
            $this->equipment->removeElement($equipment);
        }

        return $this;
    }

    /**
     * @return Collection|FlatPreference[]
     */
    public function getPreferences(): Collection
    {
        return $this->preferences;
    }

    public function addPreference(FlatPreference $preference): self
    {
        if (!$this->preferences->contains($preference)) {
            $this->preferences[] = $preference;
        }

        return $this;
    }

    public function removePreference(FlatPreference $preference): self
    {
        if ($this->preferences->contains($preference)) {
            $this->preferences->removeElement($preference);
        }

        return $this;
    }

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function setPhotos(array $photos): self
    {
        $this->photos = $photos;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone1(): ?string
    {
        return $this->phone1;
    }

    public function setPhone1(string $phone1): self
    {
        $this->phone1 = $phone1;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(?string $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFurnishings(): ?FurnitureType
    {
        return $this->furnishings;
    }

    public function setFurnishings(?FurnitureType $furnishings): self
    {
        $this->furnishings = $furnishings;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if(
            $this->getCity() &&
            Helpers::geoDistance($this->getCity()->getLat(), $this->getCity()->getLon(), $this->getLatitude(), $this->getLongitude()) > 20
        )
        {
            $context->buildViolation('Zaznaczony punkt jest za bardzo oddalony od miasta "'.$this->getCity()->getName().'"')
                ->atPath('latitude')
                ->addViolation();
        }
    }
}
