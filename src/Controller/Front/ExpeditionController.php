<?php

namespace App\Controller\Front;

use App\Entity\Booking;
use App\Entity\Expedition;
use App\Form\SearchFormType;
use App\Form\UserBookingType;
use App\Repository\ExpeditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/expedition', name: 'app_front_expedition_')]
class ExpeditionController extends AbstractController
{

    /**
     * Method to show the list of all expeditions
     *
     * @param ExpeditionRepository $expeditionRepository
     * @return Response
     */
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(ExpeditionRepository $expeditionRepository): Response
    {
        $allExpeditions = $expeditionRepository->findAll();

        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);


        return $this->render('front/expedition/list.html.twig', [
            'expeditionList' => $allExpeditions,
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show one expedition with id
     *
     * @param Expedition $expedition
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function show(Request $request, Expedition $expedition, EntityManagerInterface $entityManager): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        $booking = new Booking();

        $form = $this->createForm(UserBookingType::class, $booking, ['expedition' => $expedition]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($booking);
            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a bien été prise en compte');

            return $this->redirectToRoute('app_front_expedition_show', ['id' => $expedition->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/expedition/show.html.twig', [
            'form' => $form,
            'booking' => $booking,
            'expedition' => $expedition,
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
