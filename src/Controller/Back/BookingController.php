<?php

namespace App\Controller\Back;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/reservation', name: 'app_admin_booking_')]
class BookingController extends AbstractController
{
    /**
     * Method to show the list of all bookings
     *
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(BookingRepository $bookingRepository): Response
    {
        // here we collect all bookings
        $allBooking = $bookingRepository->findAll();

        return $this->render('back/booking/list.html.twig', [
            'bookingList' => $allBooking,
        ]);
    }

    /**
     * Method to create a booking
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/creer', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // we create the empty object
        $booking = new Booking();

        // we instantiate a form using our type
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        // we condition that the form is sent and correctly completed
        if ($form->isSubmitted() && $form->isValid()) {


            // Put on BDD
            $entityManager->persist($booking);
            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a bien été ajoutée');
            return $this->redirectToRoute('app_admin_booking_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/booking/create.html.twig', [
            'expedition' => $booking,
            'form' => $form,
        ]);
    }

    /**
     * Method to show a booking
     *
     * @param Booking $booking
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Booking $booking): Response
    {

        return $this->render('back/booking/show.html.twig', [
            'bookingShow' => $booking,
        ]);
    }

    /**
     * Method to update a booking
     *
     * @param Request $request
     * @param Booking $booking
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/modifier', name: 'update', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function update(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'Votre réservation a bien été modifiée');

            return $this->redirectToRoute('app_admin_booking_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/booking/update.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Method to delete a booking
     *
     * @param BookingRepository $bookingRepository
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return Response
     */
    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(BookingRepository $bookingRepository, EntityManagerInterface $entityManager, int $id): Response
    {

        // here we collect one booking
        $booking = $bookingRepository->find($id);
        // remove this booking
        $entityManager->remove($booking);
        // put on BDD
        $entityManager->flush();

        $this->addFlash('success', 'Votre réservation a bien été supprimée');

        return $this->redirectToRoute('app_admin_booking_list');
    }
}
