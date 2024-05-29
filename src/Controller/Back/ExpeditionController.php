<?php

namespace App\Controller\Back;

use App\Entity\Expedition;
use App\Form\ExpeditionType;
use App\Repository\ExpeditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/expedition', name: 'app_admin_expedition_')]
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
        // here we collect all expeditions
        $allExpeditions = $expeditionRepository->findAll();

        return $this->render('back/expedition/list.html.twig', [
            'expeditionList' => $allExpeditions,
        ]);
    }

    /**
     * Method to create an expedition
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/creer', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // we create the empty object
        $expedition = new Expedition();

        // we instantiate a form using our type
        $form = $this->createForm(ExpeditionType::class, $expedition);

        $form->handleRequest($request);

        // we condition that the form is sent and correctly completed
        if ($form->isSubmitted() && $form->isValid()) {


            // Put on BDD
            $entityManager->persist($expedition);
            $entityManager->flush();

            $this->addFlash('success', 'Votre expédition a bien été ajoutée.');

            return $this->redirectToRoute('app_admin_expedition_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/expedition/create.html.twig', [
            'expedition' => $expedition,
            'form' => $form,
        ]);
    }

    /** 
     * Method to show one expedition with id
     *
     * @param ExpeditionRepository $expeditionRepository
     * @param int $id
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(ExpeditionRepository $expeditionRepository, int $id): Response
    {
        // here we collect one expedition
        $oneExpedition = $expeditionRepository->find($id);

        return $this->render('back/expedition/show.html.twig', [
            'expeditionShow' => $oneExpedition,
        ]);
    }

    /**
     * Method to update an expedition
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param Expedition $expedition
     * @return Response
     */
    #[Route('/{id}/modifier', name: 'update', requirements: ['id' => '\d+'])]
    public function update(Request $request, EntityManagerInterface $entityManager, Expedition $expedition): Response
    {

        $form = $this->createForm(ExpeditionType::class, $expedition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'Votre expédition a bien été modifiée.');

            return $this->redirectToRoute('app_admin_expedition_list');
        }

        return $this->render('back/expedition/update.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Method to delete an expedition
     *
     * @param ExpeditionRepository $expeditionRepository
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return Response
     */
    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(ExpeditionRepository $expeditionRepository, EntityManagerInterface $entityManager, int $id): Response
    {

        // here we collect one expedition
        $expedition = $expeditionRepository->find($id);
        // remove this expedition
        $entityManager->remove($expedition);
        // put on BDD
        $entityManager->flush();

        $this->addFlash('success', 'Votre expédition a bien été supprimée.');

        return $this->redirectToRoute('app_admin_expedition_list');
    }
}
