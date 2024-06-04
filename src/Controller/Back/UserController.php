<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/utilisateur', name: 'app_admin_user_')]

class UserController extends AbstractController
{
    /**
     * Method to show the list of all users
     * 
     * @param UserRepository $userRepository
     * @return Response
     */
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(UserRepository $userRepository): Response
    {
        $allUsers = $userRepository->findAll();

        return $this->render('back/user/list.html.twig', [
            'userList' => $allUsers
        ]);
    }

    /**
     * Method to create an user
     * 
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/creer', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, [
            // here we setup the route as a creation account so in the form the password field is visible 
            'is_creation' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // here we set the role of an user to persist it in the DB
            $user->setRoles($form->get('roles')->getData());

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte d\'utilisateur a bien été validé.');
            return $this->redirectToRoute('app_admin_user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/user/create.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * Method to show the details of an user
     * 
     * @param User $user
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(User $user): Response
    {

        return $this->render('back/user/show.html.twig', [
            'userShow' => $user,
        ]);
    }

    /**
     * Method to show the booking of an user
     * 
     * @param User $user
     * @return Response
     */
    #[Route('/{id}/reservation', name: 'userBooking', methods: ['GET'])]
    public function userBooking(User $user): Response
    {
        return $this->render('back/user/userBooking.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Method to update an user
     * 
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/modifier', name: 'update', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function update(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(UserType::class, $user, [
            // here we setup the route as an update account so in the form the password field is not visible 
            'is_creation' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte d\'utilisateur a bien été mis à jour.');
            return $this->redirectToRoute('app_admin_user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/user/update.html.twig', [
            'userList' => $user,
            'form' => $form,
        ]);
    }

    /**
     * Method to delete an user
     * 
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Votre compte d\'utilisateur a bien été supprimé.');
        return $this->redirectToRoute('app_admin_user_list', [], Response::HTTP_SEE_OTHER);
    }
}
