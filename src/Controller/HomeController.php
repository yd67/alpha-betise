<?php

namespace App\Controller;

use App\Entity\Visite;
use App\Repository\LivresRepository;
use App\Repository\VisiteRepository;
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
    public function index(VisiteRepository $vivisteRepo, LivresRepository $livresRepo,EvenementsRepository $evenementsRepo): Response
    {
        $livres = $livresRepo->findBy([],['id'=> 'Desc'],3 );

        // recuperation d'evenements a venir 
        $dateActuel = new \DateTime('now') ;
        $events = $evenementsRepo->findNextEvents($dateActuel,1);

        // gestion des visiteur 
        $visite = new Visite();

        $ip = $_SERVER['REMOTE_ADDR']  ;
         $date = new \DateTime ;
         $nbVisite = 1 ;
        // controle si l'ip existe en base de donnes 
        $ipBase = $vivisteRepo->findIp($ip);
         if( $ipBase == null ){
            
                $visite->setIp($ip);
                $visite->setDateVisite($date);
                $visite->setNbVisite($nbVisite);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($visite);
                $entityManager->flush();
         } else{

                $ipBase->setDateVisite($date);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($ipBase);
                $entityManager->flush();
         }
     
        return $this->render('home/index.html.twig', [
            'livres' => $livres,
            'evenements'=> $events
        ]);
    }
    

}
