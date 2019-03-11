<?php

namespace App\Repository;

use App\Entity\RentRelease;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RentRelease|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentRelease|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentRelease[]    findAll()
 * @method RentRelease[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentReleaseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RentRelease::class);
    }
}