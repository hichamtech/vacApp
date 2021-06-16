<?php

namespace App\Controller;

use App\Repository\DestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(DestinationRepository $destinationRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'destinations' => $destinationRepository->findAll(),
        ]);
    }
}
