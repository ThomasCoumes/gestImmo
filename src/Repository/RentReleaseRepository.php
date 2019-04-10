<?php

namespace App\Repository;

use App\Entity\RentRelease;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RentRelease|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentRelease|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentRelease[]    findAll()
 * @method RentRelease[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class RentReleaseRepository
 * @package App\Repository
 */
class RentReleaseRepository extends ServiceEntityRepository
{
    /**
     * RentReleaseRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RentRelease::class);
    }

    /**
     * @param $year
     * @return array
     */
    public function findByYear($year): array
    {
        $qb = $this->createQueryBuilder('rr')
            ->andWhere('YEAR(rr.date) = :year')
            ->setParameter('year', $year)
            ->orderBy('rr.date', 'ASC')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param User $user
     * @return Query
     */
    public function findByUserQuery(User $user): Query
    {
        $qb = $this->createQueryBuilder('rr')
            ->andWhere('rr.userRentRelease = :user')
            ->setParameter('user', $user)
            ->orderBy('rr.date', 'DESC')
            ->getQuery();

        return $qb;
    }
}
