<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\LoginAttempt;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Attention à bien étendre ServiceEntityRepository, sinon votre repository ne pourra pas être autowiré.
 *
 * @method LoginAttempt|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginAttempt|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginAttempt[]    findAll()
 * @method LoginAttempt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginAttemptRepository extends ServiceEntityRepository
{
    const DELAY_IN_MINUTES = 10;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LoginAttempt::class);
    }

    public function countRecentLoginAttempts(string $username): int
    {
        $timeAgo = new \DateTimeImmutable(sprintf('-%d minutes', self::DELAY_IN_MINUTES));
        return $this->createQueryBuilder('la')
            ->select('COUNT(la)')
            ->where('la.date >= :date')
            ->andWhere('la.username = :username')
            ->getQuery()
            ->setParameters([
                'date' => $timeAgo,
                'username' => $username,
            ])
            ->getSingleScalarResult();
    }
}
