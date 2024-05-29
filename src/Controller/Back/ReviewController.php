<?php

namespace App\Controller\Back;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/commentaire', name: 'app_admin_review_')]
class ReviewController extends AbstractController
{

    /**
     * Method wo show list of reviews on the back office
     *
     * @param ReviewRepository $reviewRepository
     * @return Response
     */
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(ReviewRepository $reviewRepository): Response
    {
        // here we collect all reviews
        $allreviews = $reviewRepository->findAll();

        return $this->render('back/review/list.html.twig', [
            'reviewList' => $allreviews,
        ]);
    }

    /**
     * Method to show one review
     *
     * @param Review $review
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Review $review): Response
    {

        return $this->render('back/review/show.html.twig', [
            'reviewShow' => $review,
        ]);
    }

    /**
     * Method to delete one review
     *
     * @param ReviewRepository $reviewRepository
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return Response
     */
    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(ReviewRepository $reviewRepository, EntityManagerInterface $entityManager, int $id): Response
    {

        // here we collect one review
        $review = $reviewRepository->find($id);
        // remove this review
        $entityManager->remove($review);
        // put on BDD
        $entityManager->flush();

        $this->addFlash('review success', 'Le commentaire a bien été supprimé');

        return $this->redirectToRoute('app_admin_review_list');
    }
}
