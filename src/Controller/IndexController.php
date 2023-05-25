<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CategorySearch;
use App\Entity\Product;
use App\Entity\PropertySearch;
use App\Form\CategorySearchType;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Form\PropertySearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ArticleType;

class IndexController extends AbstractController
{
    #[Route('/articles', name: 'app_index')]
    public function index(ManagerRegistry $doctrine, Request $request)
    {
        $article = new Product();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->persist($article);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_index');
        }
        $repository = $doctrine->getRepository(Product::class);
        $articles = $repository->findAll();
        return $this->render('index/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView()
        ]);
    }

    #[Route('/articles/ajouter', name: 'app_add')]
    public function add(ManagerRegistry $doctrine, Request $request)
    {
        $article = new Product();
        $form = $this->createForm(ProductType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->persist($article);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_index');
        }
        return $this->render('index/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}