<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\EventsParticipantRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index( EventsParticipantRepository $EventsParticipantRepo ): Response
    {
        // rechercher les evements auquel l'utilisateur est inscrit 
        $userId =$this->getUser()->getId();
        $eventUserP = $EventsParticipantRepo->findEventUser($userId);

        // rechercher les commandes de l'utilisateur 


        // gestion de l'age a partir de la date de naissance 
        $datetime = date_format($this->getUser()->getAge(), 'Y-m-d');
        $timestamp = strtotime($datetime);
        $age = abs((time() - $timestamp) / (3600 * 24 * 365));
        $age = floor($age);
    
        return $this->render('profil/index.html.twig', [
            'ageUser' => $age,
            'eventsP' => $eventUserP
        ]);
    }
}
