<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommandeRepository;
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
    
    
}
