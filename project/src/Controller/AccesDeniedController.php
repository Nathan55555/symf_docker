<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccesDeniedController extends AbstractController
{
    #[Route('/acces_denied', name: 'app_acces_denied')]
    public function index(): Response
    {
        return $this->render('acces_denied/index.html.twig', [
            'controller_name' => 'AccesDeniedController',
        ]);
    }
}
