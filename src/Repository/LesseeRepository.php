<?php

namespace App\Repository;

use App\Entity\Lessee;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lessee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lessee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lessee[]    findAll()
 * @method Lessee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class LesseeRepository
 * @package App\Repository
 */
class LesseeRepository extends ServiceEntityRepository
{
    /**
     * LesseeRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lessee::class);
    }

    /**
     * @param User $user
     * @return Query
     */
    public function findLesseeByUserQuery(User $user): Query
    {
        $qb = $this->createQueryBuilder('l')
            ->andWhere('l.userLessee = :user')
            ->setParameter('user', $user)
            ->orderBy('l.id', 'ASC');

        return $qb->getQuery();
    }
}
