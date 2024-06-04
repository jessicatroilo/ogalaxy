<?php

namespace App\Controller\Back;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class MainController extends AbstractController
{
    /**
     * Method to show the main page of the admin
     *
     * @return Response
     */
    #[Route('/admin', name: 'app_admin_main')]

    public function homeAdmin(): Response
    {
        return $this->render('back/main/index.html.twig', [
        ]);
    }
}
