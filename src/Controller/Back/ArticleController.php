<?php

namespace App\Controller\Back;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/article', name: 'app_admin_article_')]
class ArticleController extends AbstractController
{
    /**
     * Method to show the list of all articles
     *
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(ArticleRepository $articleRepository): Response
    {
        // here we collect all articles
        $allArticle = $articleRepository->findAll();

        return $this->render('back/article/list.html.twig', [
            'articleList' => $allArticle,
        ]);
    }

    /**
     * Method to create an article
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/creer', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // we create the empty object
        $article = new Article();
        $article->setCreatedAt(new \DateTimeImmutable());

        // we instantiate a form using our type
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        // we condition that the form is sent and correctly completed
        if ($form->isSubmitted() && $form->isValid()) {


            // Put on BDD
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Votre article a bien été ajouté');
            return $this->redirectToRoute('app_admin_article_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/article/create.html.twig', [
            'form' => $form,
        ]);
    }

    /** 
     * Method to show one article with id
     * 
     * @param Article $article 
     * @return Response
     */
    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Article $article): Response
    {

        return $this->render('back/article/show.html.twig', [
            'articleShow' => $article,
        ]);
    }

    /**
     * Method to update an article
     *
     * @param Request $request
     * @param Article $article
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/modifier', name: 'update', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function update(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'Votre article a bien été modifié');

            return $this->redirectToRoute('app_admin_article_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/article/update.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * Method to delete an article
     *
     * @param ArticleRepository $articleRepository
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return Response
     */
    #[Route('/{id}/supprimer', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, int $id): Response
    {

        // here we collect one article
        $article = $articleRepository->find($id);
        // remove this article
        $entityManager->remove($article);
        // put on BDD
        $entityManager->flush();

        $this->addFlash('success', 'Votre article a bien été supprimé');

        return $this->redirectToRoute('app_admin_article_list');
    }
}
