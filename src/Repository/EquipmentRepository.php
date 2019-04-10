<?php

namespace App\Repository;

use App\Entity\Equipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Equipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipment[]    findAll()
 * @method Equipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class EquipmentRepository
 * @package App\Repository
 */
class EquipmentRepository extends ServiceEntityRepository
{
    /**
     * EquipmentRepository constructor.
     * @param RegistryInterface $registry*
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Equipment::class);
    }
}
