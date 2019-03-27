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
        $uniqueName = ucfirst($form->getData()->getUniqueName());
        $city = ucfirst($form->getData()->getCity());
        if ($form->getData()->getDescription() !== null) {
           $description =  ucfirst($form->getData()->getDescription());
           $property->setDescription($description);
        }

        $property->setUniqueName($uniqueName);
        $property->setCity($city);

        $this->manager->persist($property);
        $this->manager->flush();
    }
}
