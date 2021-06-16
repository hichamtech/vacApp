<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Entity\Rating;
use App\Entity\Review;
use App\Form\RatingType;
use App\Form\ReviewType;
use App\Manager\ReviewManagerInterface;
use App\Repository\DestinationRepository;
use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DestinationController
 * @package App\Controller
 */
class DestinationController extends AbstractController
{
    const NOTATION = 'NOTATION';

    /**
     * @Route("/destination", name="destination")
     */
    public function index(DestinationRepository $destinationRepository): Response
    {
        return $this->render('destination/index.html.twig', [
            'destinations' => $destinationRepository->findAll(),
        ]);
    }

    /**
     * @Route("destination/{id}", name="destination_detail", methods={"GET","POST"})
     */
   public function show(Destination $destination, Request $request,RatingRepository $ratingRepository): Response
    {
        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $review->setReviewer($this->getUser());
            $review->setDestination($destination);
            $review->setNotation(self::NOTATION);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('destination_detail',[
                'id' => $destination->getId()
            ]);
        }
        $reviewsList = $destination->getReviews();

        return $this->render('destination/destination_detail.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
            'reviewsList' => $reviewsList,
            'rates' => $ratingRepository->findAll()
        ]);

    }
    /**
     * @Route("visited/{id}",name="visited", methods={"POST","GET"})
     */
    public function visited(DestinationRepository $destinationRepository,Request $request):Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var  Destination $destination */
        $destination = $request->get('id');

        $visitedDestination = $destinationRepository->find($destination);

        $visitedDestination->addUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($visitedDestination);
        $entityManager->flush();

        $this->addFlash('success', 'Visite Enregistrer');

        return $this->redirectToRoute('destination_detail',[
            'id' => $visitedDestination->getId()
        ]);

    }

    /**
     * @Route("rated/{destinationId}/{ratingId}",name="rated", methods={"POST","GET"})
     */
    public function rate(DestinationRepository $destinationRepository,RatingRepository $ratingRepository,Request $request):Response
    {
        /** @var  Destination $destination */
        $destination = $request->get('destinationId');

        /** @var Rating $rating */
        $ratingId = $request->get('ratingId');

        $ratedDestination = $destinationRepository->find($destination);
        $rating = $ratingRepository->find($ratingId);

        $ratedDestination->addRating($rating);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($ratedDestination);
        $entityManager->flush();

        $this->addFlash('success', 'Rated');

        return $this->redirectToRoute('destination_detail',[
            'id' => $ratedDestination->getId()
        ]);
    }
}
