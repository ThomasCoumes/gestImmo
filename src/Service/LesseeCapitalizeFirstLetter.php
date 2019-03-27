<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 27/03/19
 * Time: 11:45
 */

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class LesseeCapitalizeFirstLetter
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * LesseeCapitalizeFirstLetter constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function capitalizeFirstLetter($form, $lessee)
    {
        $name = ucfirst($form->getData()->getName());
        $lastName = ucfirst($form->getData()->getLastName());
        $fullName = $name . ' ' . $lastName;
        $placeOfBirth = ucfirst($form->getData()->getPlaceOfBirth());

        $lessee->setName($lastName);
        $lessee->setLastname($name);
        $lessee->setFullName($fullName);
        $lessee->setPlaceOfBirth($placeOfBirth);

        $this->manager->persist($lessee);
        $this->manager->flush();
    }
}
