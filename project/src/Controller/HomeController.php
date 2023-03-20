<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;;
use Symfony\Component\Routing\Annotation\Route;
use SpotifyWebAPI\SpotifyWebAPI;
use App\Form\TitreType;
#[Route('/profile', name: 'app_profile')]
class HomeController extends AbstractController
{

    
    #[Route('/', name: 'app_home')]
    public function index(SpotifyWebAPI $api,Request $request): Response
    {
        $form = $this->createForm(TitreType::class);
        
        // Traitez le formulaire si une demande est soumise
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->getData()['search'];
            $search = $api->search($searchTerm,'track');
            $l = $search->tracks->items;
           
            $names = array();

            foreach($l as $item) {
                $id = $item->id;
                $artiste = $api->getTrack($id);
                $son = $artiste->preview_url;
                $name_song = $artiste->name;
                $img = $artiste->album->images[0]->url;
                $name = $artiste->artists[0]->name;

                $names[$name] = array(
                    'image' => $img,
                    'id' => $id,
                    'song' => $son,
                    'name_song' => $name_song
                );
            }
            // dd($names);
        // $id = $search->tracks->items[0]->id;
     
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'names' => $names,
            'musiques_count' => count($names)
        ]);
            // Faites quelque chose avec la valeur du champ de recherche (par exemple, recherchez dans une base de données)
        }
        
        return $this->render('home/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
        
    
}
