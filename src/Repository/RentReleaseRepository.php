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

    /**
     * @param $year
     * @return array
     */
    public function findByYear($year): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM rent_release r WHERE YEAR(`date`) = :yearRequested';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['yearRequested' => $year]);

        return $stmt->fetchAll();

//        $qb = $this->createQueryBuilder('rr')
//            ->andWhere('rr.date = :year')
//            ->setParameter('year', $year)
//            ->orderBy('rr.date', 'ASC')
//            ->getQuery();
//
//        return $qb->execute();
    }
}
