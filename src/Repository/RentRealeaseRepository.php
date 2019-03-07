<?php

namespace App\Repository;

use App\Entity\RentRealease;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RentRealease|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentRealease|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentRealease[]    findAll()
 * @method RentRealease[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentRealeaseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RentRealease::class);
    }
}
