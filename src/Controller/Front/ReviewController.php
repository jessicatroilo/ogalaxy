<?php

namespace App\Controller\Front;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Entity\Expedition;
use App\Form\SearchFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commentaire', name: 'app_front_review_', methods: ['GET', 'POST'])]
class ReviewController extends AbstractController
{
    /**
     * Method to add a review
     *
     * @param Request $request
     * @param Expedition $expedition
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/ajouter/{id}', name: 'add')]
    public function add(Request $request, Expedition $expedition, EntityManagerInterface $entityManager): Response
    {
        // get the search form in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        // create the empty object
        $review = new Review();

        //create the form and link it to the object
        $form = $this->createForm(ReviewType::class, $review);

        // link between the form and the request
        $form->handleRequest($request);

        // if the form is submitted and valid so I can persist in the database
        if ($form->isSubmitted() && $form->isValid()) {

            $review->setExpedition($expedition);
            $review->setUser($this->getUser());
            $review->setCreatedAt();

            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $originalFileName = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
                $newFileName = $safeFileName . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                $pictureFile->move(
                    $this->getParameter('profile_picture_directory'),
                    $newFileName
                );
                // update the picture property of the Review object
                $review->setPicture($newFileName);
            }


            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('app_front_expedition_show', ['id' => $expedition->getId()]);
        }

        return $this->render('front/review/add.html.twig', [
            "form" => $form,
            'user' => $this->getUser(), //get photo user to display in the navbar
            'expedition' => $expedition,
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
