<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoginAttemptRepository")
 * @ORM\Table()
 */
class LoginAttempt
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type("integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank
     * @Assert\Ip
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Assert\NotBlank
     * @Assert\DateTime
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $username;

    /**
     * LoginAttempt constructor.
     * @param string|null $ipAddress
     * @param string|null $username
     * @throws \Exception
     */
    public function __construct(?string $ipAddress, ?string $username)
    {
        $this->ipAddress = $ipAddress;
        $this->username = $username;
        $this->date = new \DateTimeImmutable('now');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }
}
