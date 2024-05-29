<?php

namespace App\Controller\Front;

use App\Form\SearchFormType;
use App\Form\ModifyProfileType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profil', name: 'app_front_profile_')]
class ProfileController extends AbstractController
{
    /**
     * Method Display user profile
     *
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    #[Route('/', name: 'show', methods: ['GET', 'POST'])]
    public function show(BookingRepository $bookingRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // get the search form in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        // get user who is connected
        $user = $this->getUser();

        // get user bookings - Waiting status - Validate status - Canceled status
        $waitingBookings = $bookingRepository->findByWaitingStatus($user);
        $validateBookings = $bookingRepository->findByValidateStatus($user);
        $canceledBookings = $bookingRepository->findByCanceledStatus($user);


        // form to modify profile

        $form = $this->createForm(ModifyProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // upload picture and save it in the database
            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $originalFileName = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
                $newFileName = $safeFileName . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                $pictureFile->move(
                    $this->getParameter('profile_picture_directory'),
                    $newFileName
                );


                // Update the picture property of the User object
                $user->setPicture($newFileName);
            }

            $entityManager->flush();

            $this->addFlash('profile success', 'Vos informations ont bien été modifiées');

            return $this->redirectToRoute('app_front_profile_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front/profile/profile.html.twig', [
            'user' => $user,
            'waitingBookings' => $waitingBookings,
            'validateBookings' => $validateBookings,
            'canceledBookings' => $canceledBookings,
            'form' => $form,
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
