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
     * @param $date
     * @return Response
     */
    public function monthlyCalcul(RentReleaseRepository $rentReleaseRepository, $date)
    {
        $displayDate = $date;

        if (substr($date, 0, 7) === 'Janvier') {
            $date = str_replace('Janvier ', '01-', $date);
        } elseif (substr($date, 0, 7) === 'Février') {
            $date = str_replace('Février ', '02-', $date);
        } elseif (substr($date, 0, 4) === 'Mars') {
            $date = str_replace('Mars ', '03-', $date);
        } elseif (substr($date, 0, 5) === 'Avril') {
            $date = str_replace('Avril ', '04-', $date);
        } elseif (substr($date, 0, 3) === 'Mai') {
            $date = str_replace('Mai ', '05-', $date);
        } elseif (substr($date, 0, 4) === 'Juin') {
            $date = str_replace('Juin ', '06-', $date);
        } elseif (substr($date, 0, 7) === 'Juillet') {
            $date = str_replace('Juillet ', '07-', $date);
        } elseif (substr($date, 0, 4) === 'Août') {
            $date = str_replace('Août ', '08-', $date);
        } elseif (substr($date, 0, 9) === 'Septembre') {
            $date = str_replace('Septembre ', '09-', $date);
        } elseif (substr($date, 0, 7) === 'Octobre') {
            $date = str_replace('Octobre ', '10-', $date);
        } elseif (substr($date, 0, 7) === 'Novembre') {
            $date = str_replace('Novembre ', '11-', $date);
        } elseif (substr($date, 0, 8) === 'Décembre') {
            $date = str_replace('Décembre ', '12-', $date);
        } else {
            throw new LogicException('OK ... So ... There is a problem');
        }

        $date = new \DateTime('01-' . $date);

        $rentRelease = $rentReleaseRepository->findBy(
            [
                'userRentRelease' => $this->getUser(),
                'date' => $date,
            ]
        );

        $propertyRent = [];

        foreach ($rentRelease as $release) {
            $propertyName = $release->getPropertyName();
            if (array_key_exists($propertyName, $propertyRent)) {
                $amount = $propertyRent[$propertyName] + $release->getAmount();
            } else {
                $amount = $release->getAmount();
            }

            $propertyRent[$propertyName] = $amount;
        }

        $totalByMonth = 0;
        foreach ($propertyRent as $amount) {
            $totalByMonth = $totalByMonth + $amount;
        }

        return $this->render('resume_page/month.html.twig', [
            'date' => $displayDate,
            'property' => $propertyRent,
            'total' => $totalByMonth,
        ]);
    }

    /**
     * @Route("/{year}", name="year_resume", methods={"GET"})
     * @param RentReleaseRepository $rentReleaseRepository
     * @param $year
     * @return Response
     */
    public function yearCalcul(RentReleaseRepository $rentReleaseRepository, $year)
    {
        $rentRelease = $rentReleaseRepository->findByYear($year);

        return $this->render('resume_page/year.html.twig', [
            'year' => $year,
        ]);
    }
}
