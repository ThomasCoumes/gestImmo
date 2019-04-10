<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 27/03/19
 * Time: 11:45
 */

namespace App\Service;

use App\Entity\Lessee;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LesseeCapitalizeFirstLetter
 * @package App\Service
 */
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

    /**
     * @param $form
     * @param $lessee
     */
    public function capitalizeFirstLetter($form, Lessee $lessee)
    {
        $name = mb_convert_case($form->getData()->getName(), MB_CASE_TITLE);
        $lastName = mb_convert_case($form->getData()->getLastName(), MB_CASE_TITLE);
        $fullName = $name . ' ' . $lastName;
        $placeOfBirth = mb_convert_case($form->getData()->getPlaceOfBirth(), MB_CASE_TITLE);

        $lessee->setName($lastName);
        $lessee->setLastname($name);
        $lessee->setFullName($fullName);
        $lessee->setPlaceOfBirth($placeOfBirth);

        $this->manager->persist($lessee);
        $this->manager->flush();
    }
}
