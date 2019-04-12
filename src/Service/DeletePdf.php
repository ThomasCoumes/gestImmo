<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 12/04/19
 * Time: 20:29
 */

namespace App\Service;

use App\Entity\RentRelease;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class DeletePdf
 * @package App\Service
 */
class DeletePdf
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * DeletePdf constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param RentRelease $rentRelease
     */
    public function deletePdf(RentRelease $rentRelease)
    {
        $filesystem = new Filesystem();

        $pdfFile = $rentRelease->getPdf();
        $filesystem->remove("generated/pdf/$pdfFile");

        $rentRelease->setPdf(null);

        $this->manager->persist($rentRelease);
    }
}