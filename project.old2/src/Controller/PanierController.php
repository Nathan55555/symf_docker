<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request): Response
    {
        $cart = $request->getSession()->get('cart', []);
        // dd($cart);

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'cart' => $cart,
        ]);
    }
    #[Route('/panier/add/{id}', name: 'app_panier_add')]
    public function addToCart(Request $request,ArticlesRepository $articlesRepository, $id)
{
    $art = $articlesRepository->find($id);
    // dd($art->getArtLabel());
    // Récupérer le panier depuis la session ou créer un nouveau panier vide
    $cart = $request->getSession()->get('cart', []);

    // Vérifier si le produit est déjà dans le panier
    if (isset($cart[$id])) {
        // Le produit est déjà dans le panier, augmenter la quantité
        $cart[$id]['qtn']++;
    } else {
        // Le produit n'est pas encore dans le panier, l'ajouter avec une quantité de 1
        $cart[$id] = ['id' => $id,'label'=>$art->getArtLabel(),'picture'=>$art->getArtPicture(), 'qtn' => 1];
        
    }

    // Enregistrer le panier dans la session
    $request->getSession()->set('cart', $cart);
    // $cart = $request->getSession()->set('cart', []);
   
    // Rediriger vers la page de liste des produits
    return $this->redirectToRoute('app_home');
}
#[Route('/panier/del/{id}', name: 'app_panier_del')]
public function removeFromCart(Request $request, $id): Response
{
    // Récupérer le panier depuis la session
    $cart = $request->getSession()->get('cart', []);

    // Vérifier si le produit est dans le panier
    if (isset($cart[$id])) {
        // Le produit est dans le panier, le supprimer
        unset($cart[$id]);
    }

    // Enregistrer le panier dans la session
    $request->getSession()->set('cart', $cart);

    // Rediriger vers la page de panier
    return $this->redirectToRoute('app_panier');
}


}
