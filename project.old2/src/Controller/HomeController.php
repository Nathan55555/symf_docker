<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticlesRepository $articlesRepository,Request $request): Response
    {
        $flashBag = $request->getSession()->getFlashBag();
        $errorMessage = $flashBag->get('error');
        $art = $articlesRepository->findall();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles'=>$art,
            'error2' => $errorMessage,
        ]);
    }
}
