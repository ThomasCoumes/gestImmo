<?php

namespace App\Controller;

use App\Service\RentReleaseInsertion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/accueil", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param User $user
     */
    public function index(RentReleaseInsertion $rentReleaseInsertion)
    {
        $user = $this->getUser();

        if (in_array('ROLE_LESSEE', $user->getRoles())) {
            return $this->redirectToRoute('property_index');
        }

        dump($rentReleaseInsertion);die;

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
