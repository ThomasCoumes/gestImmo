<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 27/03/19
 * Time: 11:45
 */

namespace App\Service;

use App\Entity\Lessee;
use App\Entity\Property;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormInterface;

/**
 * Class CapitalizeFirstLetter
 * @package App\Service
 */
class CapitalizeFirstLetter
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * CapitalizeFirstLetter constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FormInterface $form
     * @param Lessee $lessee
     */
    public function capitalizeLesseeFirstLetter(FormInterface $form, Lessee $lessee)
    {
        $name = mb_convert_case($form->getData()->getName(), MB_CASE_TITLE);
        $lastName = mb_convert_case($form->getData()->getLastName(), MB_CASE_TITLE);
        $fullName = $name . ' ' . $lastName;
        $placeOfBirth = mb_convert_case($form->getData()->getPlaceOfBirth(), MB_CASE_TITLE);

        $lessee->setName($name);
        $lessee->setLastname($lastName);
        $lessee->setFullName($fullName);
        $lessee->setPlaceOfBirth($placeOfBirth);

        $this->manager->persist($lessee);
    }

    /**
     * @param FormInterface $form
     * @param Property $property
     */
    public function capitalizePropertyFirstLetter(FormInterface $form, Property $property)
    {
        $uniqueName = mb_convert_case($form->getData()->getUniqueName(), MB_CASE_TITLE);
        $city = mb_convert_case($form->getData()->getCity(), MB_CASE_TITLE);
        if ($form->getData()->getDescription() !== null) {
            $capitalize = mb_convert_case($form->getData()->getDescription(), MB_CASE_TITLE);
            $firstChar = mb_substr($capitalize, 0, 1);
            $endOfDescription = mb_substr($form->getData()->getDescription(), 1);

            $property->setDescription($firstChar . $endOfDescription);
        }

        $property->setUniqueName($uniqueName);
        $property->setCity($city);

        $this->manager->persist($property);
    }
}
