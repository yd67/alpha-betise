<?php

namespace App\Controller;

use App\Repository\LivresRepository;
use App\Repository\EvenementsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(LivresRepository $livresRepo,EvenementsRepository $evenementsRepo): Response
    {
        $livres = $livresRepo->findBy([],['id'=> 'Desc'],3 );

        // recuperation d'evenements a venir 
        $dateActuel = new \DateTime('now') ;
        $events = $evenementsRepo->findNextEvents($dateActuel,1);
        
        return $this->render('home/index.html.twig', [
            'livres' => $livres,
            'evenements'=> $events
        ]);
    }
    

}
