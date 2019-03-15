<?php

namespace App\Controller;

use App\Repository\RentReleaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\Response;
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
        $yearList = [];

        foreach ($release as $rentRelease) {
            $numericDate = $rentRelease->getDate()->format('m-Y');
            $year = $rentRelease->getDate()->format('Y');

            if (substr($numericDate, 0, 3) === '01-') {
                $date = str_replace('01-', 'Janvier ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '02-') {
                $date = str_replace('02-', 'Février ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '03-') {
                $date = str_replace('03-', 'Mars ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '04-') {
                $date = str_replace('04-', 'Avril ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '05-') {
                $date = str_replace('05-', 'Mai ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '06-') {
                $date = str_replace('06-', 'Juin ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '07-') {
                $date = str_replace('07-', 'Juillet ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '08-') {
                $date = str_replace('08-', 'Août ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '09-') {
                $date = str_replace('09-', 'Septembre ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '10-') {
                $date = str_replace('10-', 'Octobre ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '11-') {
                $date = str_replace('11-', 'Novembre ', $numericDate);
            } elseif (substr($numericDate, 0, 3) === '12-') {
                $date = str_replace('12-', 'Décembre ', $numericDate);
            } else {
                throw new LogicException('OK ... So ... There is a problem');
            }

            if (!in_array($date, $dateList, true)) {
                $dateList[] = $date;
            }

            if (!in_array($year, $yearList, true)) {
                $yearList[] = $year;
            }
        }

        return $this->render('resume_page/index.html.twig', [
            'date' => $dateList,
            'year' => $yearList,
        ]);
    }

    /**
     * @Route("/month/{date}", name="monthly_resume", methods={"GET"})
     * @param RentReleaseRepository $rentReleaseRepository
     * @return Response
     */
    public function monthlyCalcul(RentReleaseRepository $rentReleaseRepository)
    {
        $release = $rentReleaseRepository->findBy(
            [
                'userRentRelease' => $this->getUser(),
            ]
        );

        return $this->render('resume_page/month.html.twig');
    }
}
