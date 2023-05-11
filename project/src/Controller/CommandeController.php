<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommandeRepository;
use App\Repository\ArticlesRepository;
use App\Repository\OrderDetailRepository;
use App\Entity\Commande;
use App\Entity\OrderDetail;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\UserRepository;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
            public function index(OrderDetailRepository $orderrepo,Request $req,CommandeRepository $com, Security $security, UserRepository $userRepository,SessionInterface $session): Response
            {
                $user = $security->getUser();
                if (!$user) {
                    $session->getFlashBag()->add('error', 'Vous devez vous connecter avant de passer une commande.');
                    return $this->redirectToRoute('app_login');
                }
            
                // dd($req->getSession()->get('cart', []));
                if($req->getSession()->get('cart', [])==[])
                {
                    $session->getFlashBag()->add('error', 'Vous devez ajouter des articles pour passer une commande.');
                    return $this->redirectToRoute('app_home');
                }
                $userId = $user->getId();
                $userEntity = $userRepository->find($userId);
                $coma = new Commande;
                $coma->setUserid($userEntity);
                $com->save($coma, true);
                $lastCommande = $com->findOneBy(['user_id' => $userEntity], ['id' => 'DESC']);
                $cart = $req->getSession()->get('cart', []);
                foreach ($cart as $item) {
                    $order = new OrderDetail;
                    $ord = $order->setComId( $lastCommande);
                    $ord = $order->setIdArt($item['id']);
                    $ord = $order->setOrdQtn($item['qtn']);
                    $orderrepo->save($ord,true);
                }
                $orderDetails = array();
                foreach ($cart as $item) {
                    $orderDetail = array(
                        'commande_id' => $lastCommande->getId(),
                        'article_id' => $item['id'],
                        'quantite' => $item['qtn'],
                        'photo' => $item['picture'],
                    );
                    array_push($orderDetails, $orderDetail);
                }
                $cart = $req->getSession()->set('cart', []);
                return $this->render('commande/index.html.twig', [
                    'order' => $orderDetails,
                ]);
            
    }

    #[Route('/commande/u/{id}', name: 'app_commande_liste')]
    public function order_user(OrderDetailRepository $orderrepo, CommandeRepository $comrepo,UserRepository $userRepository,$id): Response
    {
      return $this->render('commande/liste.html.twig', [
        'orderlist' => $comrepo->findCommandesByUser($id),
    ]);
}

    #[Route('/commande/detail/{id}', name: 'app_commande_users')]
     public function order_detail_user(ArticlesRepository $artrepo,CommandeRepository $comrepo, OrderDetailRepository $orderrep ,$id): Response
    {
       $order =  $orderrep->findByExampleField($id) ;
       $arrayorder = [];
       $orderDetails = [];
       foreach ($order as $o) {
            $id = $o->getIdart(); 
            $art = $artrepo->find($id);
            $arrayorder = array(
                'order_id' => $o->getId(),
                'article_id' => $art->getId(),
                'article_name' => $art->getArtLabel(),
                'article_quantity' => $o->getOrdQtn(),
                'articles_photo' => $art->getArtPicture(),);
                array_push($orderDetails, $arrayorder);
                // Ajouter d'autres détails de la commande ici
            
           

       
    }
   
       
      
        return $this->render('commande/detail.html.twig', [
            'orderlist' => $orderDetails,
            'id' => $id,
        ]);

    }



    }
    

