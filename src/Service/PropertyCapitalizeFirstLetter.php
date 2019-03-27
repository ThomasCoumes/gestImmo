<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 27/03/19
 * Time: 12:11
 */

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class PropertyCapitalizeFirstLetter
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

    public function capitalizeFirstLetter($form, $property)
    {
        $uniqueName = mb_convert_case($form->getData()->getUniqueName(), MB_CASE_TITLE);
        $city = mb_convert_case($form->getData()->getCity(), MB_CASE_TITLE);
        if ($form->getData()->getDescription() !== null) {
            $capitalize = mb_strtoupper($form->getData()->getDescription());
            $firstChar = mb_substr($capitalize, 0, 1);
            $endOfDescription = mb_substr($form->getData()->getDescription(), 1);

            $property->setDescription($firstChar . $endOfDescription);
        }

        $property->setUniqueName($uniqueName);
        $property->setCity($city);

        $this->manager->persist($property);
        $this->manager->flush();
    }
}
