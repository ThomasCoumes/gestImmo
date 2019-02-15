<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
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
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type("string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Assert\Type("array")
     * @var array
     */
    private $propertyWhoGetIt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="equipments")
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $equipment;

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): int
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): string
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPropertyWhoGetIt()
    {
        return $this->propertyWhoGetIt;
    }

    /**
     * @param mixed $propertyWhoGetIt
     */
    public function setPropertyWhoGetIt($propertyWhoGetIt)
    {
        $this->propertyWhoGetIt = $propertyWhoGetIt;
    }

    /**
     * @return Property|null
     */
    public function getEquipment(): ?Property
    {
        return $this->equipment;
    }

    /**
     * @param Property|null $equipment
     * @return Equipment
     */
    public function setEquipment(?Property $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }
}
