<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\SearchFormType;
use App\Repository\ExpeditionRepository;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Method to show the main page of the site
     *
     * @param ExpeditionRepository $expeditionRepository
     * @return Response
     */
    #[Route('/', name: 'app_home')]
    public function index(ExpeditionRepository $expeditionRepository): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        $expeditionBestRating = $expeditionRepository->findByBestRating();

        $expeditionDeparture = $expeditionRepository ->findByDeparture();

        $expeditionHomePage = $expeditionRepository->findByFive(); 

        return $this->render('front/home/index.html.twig', [
            'expeditionHome' => $expeditionHomePage,
            'expeditionDeparture' => $expeditionDeparture,
            'expeditionBestRating' => $expeditionBestRating,
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
            
        ]);
    }
}
