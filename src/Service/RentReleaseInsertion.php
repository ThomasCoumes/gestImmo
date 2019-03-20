<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 07/03/19
 * Time: 15:05
 */

namespace App\Service;

use App\Entity\RentRelease;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;

class RentReleaseInsertion
{
    private $propertyRepository;
    private $manager;

    public function __construct(PropertyRepository $propertyRepository, ObjectManager $manager)
    {
        $this->propertyRepository = $propertyRepository;
        $this->manager = $manager;
    }


    public function settingRentReleaseValues()
    {
        $property = $this->propertyRepository->findAll();

        foreach ($property as $prop) {
            $lessees = $prop->getLessees();
            $propertyName = $prop->getUniqueName();
            $user = $prop->getUserProperty();

            foreach ($lessees as $lessee) {
                $lesseeName = $lessee->getFullName();

                $rentRelease = new RentRelease();
                $amount = $prop->getRentExcludingCharges() + $prop->getCharges();

                $date = new \DateTime();
                $date = $date->format('m-Y');
                $date = new \DateTime('01-' . $date);

                $rentRelease->setRentRelease($lessee);
                $rentRelease->setAmount($amount);
                $rentRelease->setStatus('Paiement en attente');
                $rentRelease->setDate($date);
                $rentRelease->setPropertyName($propertyName);
                $rentRelease->setLesseeName($lesseeName);
                $rentRelease->setUserRentRelease($user);

                $this->manager->persist($rentRelease);
                $this->manager->flush();
            }
        }
    }
}
