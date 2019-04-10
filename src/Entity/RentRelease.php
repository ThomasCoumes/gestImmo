<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RentRelease
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RentReleaseRepository")
 */
class RentRelease
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
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     * @var float
     */
    private $Amount;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Choice({"Paiement en attente", "Payé"})
     * @var string
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lessee", inversedBy="rentReleases")
     * @ORM\JoinColumn(name="rent_release_id", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank
     */
    private $rentRelease;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     * @var \DateTime
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @var string
     */
    private $propertyName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @var string
     */
    private $lesseeName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rentReleases")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $userRentRelease;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @var string
     */
    private $pdf;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->Amount;
    }

    /**
     * @param float $Amount
     * @return RentRelease
     */
    public function setAmount(float $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return RentRelease
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Lessee|null
     */
    public function getRentRelease(): ?Lessee
    {
        return $this->rentRelease;
    }

    /**
     * @param Lessee|null $rentRelease
     * @return RentRelease
     */
    public function setRentRelease(?Lessee $rentRelease): self
    {
        $this->rentRelease = $rentRelease;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return RentRelease
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     * @return RentRelease
     */
    public function setPropertyName(string $propertyName): self
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLesseeName(): ?string
    {
        return $this->lesseeName;
    }

    /**
     * @param string $lesseeName
     * @return RentRelease
     */
    public function setLesseeName(string $lesseeName): self
    {
        $this->lesseeName = $lesseeName;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUserRentRelease(): ?User
    {
        return $this->userRentRelease;
    }

    /**
     * @param User|null $userRentRelease
     * @return RentRelease
     */
    public function setUserRentRelease(?User $userRentRelease): self
    {
        $this->userRentRelease = $userRentRelease;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    /**
     * @param string|null $pdf
     * @return RentRelease
     */
    public function setPdf(?string $pdf): self
    {
        $this->pdf = $pdf;

        return $this;
    }
}
