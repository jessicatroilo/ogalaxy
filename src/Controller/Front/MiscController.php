<?php

namespace App\Controller\Front;

use App\Entity\Article;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\SearchFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'app_front_')]
class MiscController extends AbstractController
{
    /**
     * Method to show a list of all articles
     *
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    #[Route('/actualites', name: 'news_list')]
    public function news(ArticleRepository $articleRepository): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        $allArticles = $articleRepository->findAllOrderedByDate();

        return $this->render('front/misc/news-list.html.twig', [
            'user' => $this->getUser(), //get photo user to display in the navbar
            'articleList' => $allArticles,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show an article
     *
     * @param int $id
     * @param Article $article
     * @return Response
     */
    #[Route('/{id}/actualites', name: 'news_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id, Article $article): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        return $this->render('front/misc/news-show.html.twig', [
            'user' => $this->getUser(), //get photo user to display in the navbar
            'article' => $article,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show the careers page
     *
     * @return Response
     */
    #[Route('/carrieres', name: 'careers')]
    public function careers(): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        return $this->render('front/misc/careers.html.twig', [
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show the confidentiality page
     *
     * @return Response
     */
    #[Route('/confidentialite', name: 'confidentiality')]
    public function confidentiality(): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        return $this->render('front/misc/confidentiality.html.twig', [
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show the contact page
     *
     * @param Request $request
     * @param Contact $contact
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contact->setCreatedAt();
            $entityManager->persist($contact);
            $entityManager->flush();

            $this->addFlash('contact', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('front/misc/contact.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show the FAQ page
     *
     * @return Response
     */
    #[Route('/faq', name: 'faq')]
    public function faq(): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        return $this->render('front/misc/faq.html.twig', [
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show the legal mentions page
     *
     * @return Response
     */
    #[Route('/mentions-legales', name: 'legal_notice')]
    public function legalMentions(): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        return $this->render('front/misc/legal-notice.html.twig', [
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show the about us page
     *
     * @return Response
     */
    #[Route('/notre-histoire', name: 'about_us')]
    public function index(): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        return $this->render('front/misc/about-us.html.twig', [
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * Method to show the our album page
     *
     * @return Response
     */
    #[Route('/notre-album', name: 'our_album')]
    public function album(): Response
    {
        //display the search bar in all pages
        $searchForm = $this->createForm(SearchFormType::class);

        return $this->render('front/misc/our-album.html.twig', [
            'controller_name' => 'AboutUsController',
            'user' => $this->getUser(), //get photo user to display in the navbar
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
