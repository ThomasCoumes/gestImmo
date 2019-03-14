<?php

namespace App\Controller;

use App\Repository\RentReleaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\LogicException;
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
     * @param RentReleaseRepository $rentReleaseRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RentReleaseRepository $rentReleaseRepository)
    {
        $release = $rentReleaseRepository->findBy(
            ['userRentRelease' => $this->getUser()]
        );
        $dateList = [];

        foreach ($release as $rentRelease) {
            $date = $rentRelease->getDate()->format('m-Y');

            if (substr($date, 0, 3) === '01-') {
                $date = str_replace('01-', 'Janvier ', $date);
            } elseif (substr($date, 0, 3) === '02-') {
                $date = str_replace('02-', 'Février ', $date);
            } elseif (substr($date, 0, 3) === '03-') {
                $date = str_replace('03-', 'Mars ', $date);
            } elseif (substr($date, 0, 3) === '04-') {
                $date = str_replace('04-', 'Avril ', $date);
            } elseif (substr($date, 0, 3) === '05-') {
                $date = str_replace('05-', 'Mai ', $date);
            } elseif (substr($date, 0, 3) === '06-') {
                $date = str_replace('06-', 'Juin ', $date);
            } elseif (substr($date, 0, 3) === '07-') {
                $date = str_replace('07-', 'Juillet ', $date);
            } elseif (substr($date, 0, 3) === '08-') {
                $date = str_replace('08-', 'Août ', $date);
            } elseif (substr($date, 0, 3) === '09-') {
                $date = str_replace('09-', 'Septembre ', $date);
            } elseif (substr($date, 0, 3) === '10-') {
                $date = str_replace('10-', 'Octobre ', $date);
            } elseif (substr($date, 0, 3) === '11-') {
                $date = str_replace('11-', 'Novembre ', $date);
            } elseif (substr($date, 0, 3) === '12-') {
                $date = str_replace('12-', 'Décembre ', $date);
            } else {
                throw new LogicException('OK ... So ... There is a problem');
            }

            if (!in_array($date, $dateList, true)) {
                $dateList[] = $date;
            }
        }

        return $this->render('resume_page/index.html.twig', [
            'date' => $dateList,
        ]);
    }
}
