<?php

namespace App\Controller\Front;

use App\Entity\Article;
use App\Entity\Expedition;
use App\Form\SearchFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * Method to search in the database
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/recherche', name: 'app_front_search', methods: ['GET'])]
    public function search(Request $request, EntityManagerInterface $entityManager)
    {
        $searchForm = $this->createForm(SearchFormType::class);
        $searchForm->handleRequest($request);

        $expeditions = []; // Init the variable empty to avoid errors
        $news = [];

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $query = $searchForm->get('query')->getData();

            //* Search in the database
            // Search in the expedition table
            $repository = $entityManager->getRepository(Expedition::class);
            $expeditions = $repository->findByTitle($query);
            $expeditions = $repository->findByDescription($query);

            // Search in the article table
            $repository = $entityManager->getRepository(Article::class);
            $news = $repository->findByText($query);
            $news = $repository->findByTitle($query);
        }

        return $this->render('front/search/result.html.twig', [
            'searchForm' => $searchForm->createView(),
            'expeditions' => $expeditions,
            'news' => $news,
            'user' => $this->getUser(), //get photo user to display in the navbar
        ]);
    }
}
