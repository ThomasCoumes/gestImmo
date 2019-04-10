<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class PropertyRepository
 * @package App\Repository
 */
class PropertyRepository extends ServiceEntityRepository
{
    /**
     * PropertyRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @param User $user
     * @return Query
     */
    public function findPropertyByUserQuery(User $user): Query
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.lessees', 'l')
            ->andWhere('p.userProperty = :user')
            ->orWhere('l.email = :userEmail')
            ->setParameter('user', $user)
            ->setParameter('userEmail', $user->getEmail())
            ->orderBy('p.id', 'ASC');

        return $qb->getQuery();
    }
}
