<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Equipment
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentRepository")
 */
class Equipment
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
     * @Assert\Type("string")
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Property", inversedBy="equipment")
     * @var ArrayCollection
     */
    private $equipment;

    /**
     * Equipment constructor.
     */
    public function __construct()
    {
        $this->equipment = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Equipment
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    /**
     * @param Property $equipment
     * @return Equipment
     */
    public function addEquipment(Property $equipment): self
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment[] = $equipment;
        }

        return $this;
    }

    /**
     * @param Property $equipment
     * @return Equipment
     */
    public function removeEquipment(Property $equipment): self
    {
        if ($this->equipment->contains($equipment)) {
            $this->equipment->removeElement($equipment);
        }

        return $this;
    }
}
