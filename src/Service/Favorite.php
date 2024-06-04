<?php

namespace App\Service;


use App\Entity\User;
use App\Entity\Expedition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Favorite
{
    // user connected
    private User $user;

    public function __construct(private Security $security, private EntityManagerInterface $entityManager, private RequestStack $requestStack)
    {
        $this->user = $this->security->getUser();
    
    }
    
    /**
     * Method to get expedition for the user connected
     */
    public function getAll()
    {
        return $this->user->getExpedition();
    }

    /**
     * Method to add the expedition is in the favorite list
     */
    public function add(Expedition $expedition)
    {
        // add the expedition to the user
        $this->user->addExpedition($expedition);
        $this->entityManager->flush();

        /**
         * @var Session
         */
        $session = $this->requestStack->getSession();
        $flashBag = $session->getFlashBag();
        $flashBag->add("favorite success", "{$expedition->getTitle()} a bien été ajouté en favoris");
    }

    /**
     * Method to remove the expedition from the favorite list
     */
    public function remove(Expedition $expedition)
    {
        // remove the expedition from the user
        $expedition->removeUser($this->user);

        $this->entityManager->flush();

        /**
         * @var Session
         */
        $session = $this->requestStack->getSession();
        $flashBag = $session->getFlashBag();
        $flashBag->add("favorite warning", "{$expedition->getTitle()} a bien été supprimé de vos favoris");
    }

    /**
     * Method to empty the favorite list
     */
    public function empty()
    {
        // remove all the expeditions from the user
        $this->user->getExpedition()->clear();
        $this->entityManager->flush();
    }
}
