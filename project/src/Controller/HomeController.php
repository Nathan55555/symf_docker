<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ArticlesRepository $articlesRepository): Response
    {
        $art = $articlesRepository->findall();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles'=>$art,
        ]);
    }
}
