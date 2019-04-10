<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LostUser
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\LostUserRepository")
 */
class LostUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} doit etre une chaine de caractères."
     * )
     * @Assert\Email(
     *     message = "Veuillez renseigner votre adresse mail.",
     *     checkMX = true
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 180,
     *      minMessage = "Votre email est trop court",
     *      maxMessage = "Votre email est trop long"
     * )
     * @var string
     */
    private $email;

    /**
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} doit etre une chaine de caractères."
     * )
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit faire au moins 8 caracteres",
     * )
     * @var string
     */
    private $newPlainPassword;

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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return LostUser
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewPlainPassword(): ?string
    {
        return $this->newPlainPassword;
    }

    /**
     * @param string|null $newPlainPassword
     * @return LostUser
     */
    public function setNewPlainPassword(?string $newPlainPassword): self
    {
        $this->newPlainPassword = $newPlainPassword;

        return $this;
    }
}
