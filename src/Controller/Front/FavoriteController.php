<?php

namespace App\Controller\Front;

use App\Service\Favorite;
use App\Entity\Expedition;
use App\Form\SearchFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/favoris', name: 'app_front_favorite_')]
class FavoriteController extends AbstractController
{

    public function __construct(private Favorite $favorite)
    {
    }

    /**
     * Display list of favorite expeditions
     * @return Response
     */
    #[Route('/', name: 'list')]
    public function list(): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        return $this->render('front/favorite/list.html.twig', [
            "expeditionList" => $this->favorite->getAll(),
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Add a favorite expedition when the button clicked
     * @return Response
     */
    #[Route('/ajouter/{id}', name: 'add', requirements: ['id' => '\d+'])]
    public function add(Request $request, Expedition $expedition): Response
    {
        $this->favorite->add($expedition);

        // get the url of the page that triggered the add
        $referer = $request->headers->get("referer");
        return $this->redirect($referer);
    }

    /**
     * Remove a favorite expedition when the button clicked
     * @return Response
     */
    #[Route('/supprimer/{id}', name: 'remove', requirements: ['id' => '\d+'])]
    public function remove(Expedition $expedition, Request $request): Response
    {


        $this->favorite->remove($expedition);

        $referer = $request->headers->get("referer");
        return $this->redirect($referer);
    }


    /**
     * Clear favorite list
     * @return Response
     */
    #[Route('/vide', name: 'empty')]
    public function empty(Request $request): Response
    {

        $this->favorite->empty();

        $referer = $request->headers->get("referer");
        return $this->redirect($referer);
    }
}
