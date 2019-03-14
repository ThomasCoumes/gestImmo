<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class ResumePageController
 * @package App\Controller
 * @Route("/resume")
 * @IsGranted("ROLE_USER")
 */
class ResumePageController extends AbstractController
{
    /**
     * @Route(name="resume_page")
     */
    public function index()
    {
        return $this->render('resume_page/index.html.twig', [
            'controller_name' => 'ResumePageController',
        ]);
    }
}
