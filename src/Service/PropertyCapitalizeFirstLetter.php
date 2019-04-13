<?php
/**
 * Created by PhpStorm.
 * User: thocou
 * Date: 27/03/19
 * Time: 12:11
 */

namespace App\Service;

use App\Entity\Property;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormInterface;

/**
 * Class PropertyCapitalizeFirstLetter
 * @package App\Service
 */
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

    /**
     * @param FormInterface $form
     * @param Property $property
     */
    public function capitalizeFirstLetter(FormInterface $form, Property $property)
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
