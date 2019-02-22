<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 */
class Property
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Choice({"Appartement", "Maison", "Garage", "Bureau", "Château", "Commerce"})
     * @var string
     */
    private $propertyCategory;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @var string
     */
    private $uniqueName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @var string
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\Length(min = 5, minMessage = "Ce champ doit contenir 5 chiffres")
     * @Assert\Length(max = 5, maxMessage = "Ce champ doit contenir 5 chiffres")
     * @var int
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Country
     * @var string
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @var string
     */
    private $surfaceInSquareMeter;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @var int
     */
    private $numberOfPiece;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type("string")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Choice({"Meublé", "Non meublé"})
     * @var string
     */
    private $rentalCategory;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     * @var float
     */
    private $rentExcludingCharges;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     * @var float
     */
    private $charges;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     * @var float
     */
    private $purchasePrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @JoinColumn(name="user_property_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $userProperty;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipment", mappedBy="equipment")
     */
    private $equipment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Lessee", mappedBy="lessee")
     */
    private $lessees;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(
     *     mimeTypes = {"application/json", "text/plain"},
     *     mimeTypesMessage = "Votre fichier n'est pas au format .json"
     * )
     */
    private $pdfFile;

    /**
     * Property constructor.
     */
    public function __construct()
    {
        $this->equipments = new ArrayCollection();
        $this->equipment = new ArrayCollection();
        $this->lessees = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getPropertyCategory(): ?string
    {
        return $this->propertyCategory;
    }

    /**
     * @param string $propertyCategory
     * @return Property
     */
    public function setPropertyCategory(string $propertyCategory): self
    {
        $this->propertyCategory = $propertyCategory;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUniqueName(): ?string
    {
        return $this->uniqueName;
    }

    /**
     * @param string $uniqueName
     * @return Property
     */
    public function setUniqueName(string $uniqueName): self
    {
        $this->uniqueName = $uniqueName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Property
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Property
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    /**
     * @param int $zipCode
     * @return Property
     */
    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Property
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSurfaceInSquareMeter(): ?int
    {
        return $this->surfaceInSquareMeter;
    }

    /**
     * @param int $surfaceInSquareMeter
     * @return Property
     */
    public function setSurfaceInSquareMeter(int $surfaceInSquareMeter): self
    {
        $this->surfaceInSquareMeter = $surfaceInSquareMeter;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumberOfPiece(): ?int
    {
        return $this->numberOfPiece;
    }

    /**
     * @param int $numberOfPiece
     * @return Property
     */
    public function setNumberOfPiece(int $numberOfPiece): self
    {
        $this->numberOfPiece = $numberOfPiece;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Property
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRentalCategory(): ?string
    {
        return $this->rentalCategory;
    }

    /**
     * @param string $rentalCategory
     * @return Property
     */
    public function setRentalCategory(string $rentalCategory): self
    {
        $this->rentalCategory = $rentalCategory;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getRentExcludingCharges(): ?float
    {
        return $this->rentExcludingCharges;
    }

    /**
     * @param float $rentExcludingCharges
     * @return Property
     */
    public function setRentExcludingCharges(float $rentExcludingCharges): self
    {
        $this->rentExcludingCharges = $rentExcludingCharges;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCharges(): ?float
    {
        return $this->charges;
    }

    /**
     * @param float $charges
     * @return Property
     */
    public function setCharges(float $charges): self
    {
        $this->charges = $charges;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    /**
     * @param float $purchasePrice
     * @return Property
     */
    public function setPurchasePrice(float $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUserProperty(): ?User
    {
        return $this->userProperty;
    }

    /**
     * @param User|null $userProperty
     * @return Property
     */
    public function setUserProperty(?User $userProperty): self
    {
        $this->userProperty = $userProperty;

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
            $equipment->addEquipment($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->contains($equipment)) {
            $this->equipment->removeElement($equipment);
            $equipment->removeEquipment($this);
        }

        return $this;
    }

    /**
     * @return Collection|Lessee[]
     */
    public function getLessees(): Collection
    {
        return $this->lessees;
    }

    public function addLessee(Lessee $lessee): self
    {
        if (!$this->lessees->contains($lessee)) {
            $this->lessees[] = $lessee;
            $lessee->addLessee($this);
        }

        return $this;
    }

    public function removeLessee(Lessee $lessee): self
    {
        if ($this->lessees->contains($lessee)) {
            $this->lessees->removeElement($lessee);
            $lessee->removeLessee($this);
        }

        return $this;
    }

    public function getPdfFile(): ?string
    {
        return $this->pdfFile;
    }

    public function setPdfFile(?string $pdfFile): self
    {
        $this->pdfFile = $pdfFile;

        return $this;
    }
}
