<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RentReleaseRepository")
 */
class RentRelease
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     */
    private $Amount;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Choice({"Paiement en attente", "Payé"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lessee", inversedBy="rentReleases")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $rentRelease;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $propertyName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $lesseeName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rentReleases")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $userRentRelease;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->Amount;
    }

    public function setAmount(float $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRentRelease(): ?Lessee
    {
        return $this->rentRelease;
    }

    public function setRentRelease(?Lessee $rentRelease): self
    {
        $this->rentRelease = $rentRelease;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    public function setPropertyName(string $propertyName): self
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    public function getLesseeName(): ?string
    {
        return $this->lesseeName;
    }

    public function setLesseeName(string $lesseeName): self
    {
        $this->lesseeName = $lesseeName;

        return $this;
    }

    public function getUserRentRelease(): ?User
    {
        return $this->userRentRelease;
    }

    public function setUserRentRelease(?User $userRentRelease): self
    {
        $this->userRentRelease = $userRentRelease;

        return $this;
    }
}
