<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentRepository")
 */
class Equipment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $elevator;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cellar;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $garden;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $parking;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $balcony;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $opticalFiber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $intercom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $terrace;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $swimmingPool;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElevator(): ?bool
    {
        return $this->elevator;
    }

    public function setElevator(?bool $elevator): self
    {
        $this->elevator = $elevator;

        return $this;
    }

    public function getCellar(): ?bool
    {
        return $this->cellar;
    }

    public function setCellar(?bool $cellar): self
    {
        $this->cellar = $cellar;

        return $this;
    }

    public function getGarden(): ?bool
    {
        return $this->garden;
    }

    public function setGarden(?bool $garden): self
    {
        $this->garden = $garden;

        return $this;
    }

    public function getParking(): ?bool
    {
        return $this->parking;
    }

    public function setParking(?bool $parking): self
    {
        $this->parking = $parking;

        return $this;
    }

    public function getBalcony(): ?bool
    {
        return $this->balcony;
    }

    public function setBalcony(?bool $balcony): self
    {
        $this->balcony = $balcony;

        return $this;
    }

    public function getOpticalFiber(): ?bool
    {
        return $this->opticalFiber;
    }

    public function setOpticalFiber(?bool $opticalFiber): self
    {
        $this->opticalFiber = $opticalFiber;

        return $this;
    }

    public function getIntercom(): ?bool
    {
        return $this->intercom;
    }

    public function setIntercom(?bool $intercom): self
    {
        $this->intercom = $intercom;

        return $this;
    }

    public function getTerrace(): ?bool
    {
        return $this->terrace;
    }

    public function setTerrace(?bool $terrace): self
    {
        $this->terrace = $terrace;

        return $this;
    }

    public function getSwimmingPool(): ?bool
    {
        return $this->swimmingPool;
    }

    public function setSwimmingPool(?bool $swimmingPool): self
    {
        $this->swimmingPool = $swimmingPool;

        return $this;
    }
}
