<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @param User $user
     * @return array
     */
    public function findPropertyByUser(User $user): array
    {
        $qb = $this->createQueryBuilder('p')
            ->innerJoin('p.lessees', 'l')
            ->andWhere('p.userProperty = :user OR l.email = :userEmail')
            ->setParameter('user', $user)
            ->setParameter('userEmail', $user->getEmail())
            ->orderBy('p.id', 'ASC')
            ->getQuery();

        return $qb->execute();
    }
}
