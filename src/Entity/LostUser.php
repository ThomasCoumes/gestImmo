<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LostUserRepository")
 */
class LostUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    private $email;

    private $newPlainPassword;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNewPlainPassword(): ?string
    {
        return $this->newPlainPassword;
    }

    public function setNewPlainPassword(?string $newPlainPassword): self
    {
        $this->newPlainPassword = $newPlainPassword;

        return $this;
    }
}
