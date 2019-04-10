<?php

namespace App\Repository;

use App\Entity\LostUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LostUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method LostUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method LostUser[]    findAll()
 * @method LostUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class LostUserRepository
 * @package App\Repository
 */
class LostUserRepository extends ServiceEntityRepository
{
    /**
     * LostUserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LostUser::class);
    }
}
