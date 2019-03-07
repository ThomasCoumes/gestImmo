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
     * @Assert\Type("integer")
     */
    private $rentRelease;

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
}
