<?php

namespace App\Controller\Back;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/contact', name: 'app_admin_contact_')]
class ContactController extends AbstractController
{
    /**
     * Method to show the list of all contacts
     *
     * @param ContactRepository $contactRepository
     * @return Response
     */
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(ContactRepository $contactRepository): Response
    {
        // here we collect all contacts
        $allcontact = $contactRepository->findAll();

        return $this->render('back/contact/list.html.twig', [
            'contactList' => $allcontact,
        ]);
    }

    /**
     * Method to create a contact
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Contact $contact): Response
    {

        return $this->render('back/contact/show.html.twig', [
            'contactShow' => $contact,
        ]);
    }

    /**
     * Method to create a contact
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(ContactRepository $contactRepository, EntityManagerInterface $entityManager, int $id): Response
    {

        // here we collect one contact
        $contact = $contactRepository->find($id);
        // remove this contact
        $entityManager->remove($contact);
        // put on BDD
        $entityManager->flush();

        $this->addFlash('success', 'Votre message a bien été supprimé');

        return $this->redirectToRoute('app_admin_contact_list');
    }
}
