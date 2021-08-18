<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibrairieController extends AbstractController
{
    /**
     * @Route("/librairie", name="librairie")
     */
    public function index(): Response
    {
        return $this->render('librairie/index.html.twig', [
            'controller_name' => 'LibrairieController',
        ]);
    }
    /**
     * @Route("/librairie/mention-legal", name="mention_legal")
     */
    public function mentionLegal(){


        return $this->render('librairie/mentionLegal.html.twig');
    }
    /**
     * @Route("/librairie/info-paiement", name="info_paiement")
     */
    public function infoPaiment (){

        return $this->render('librairie/infoPaiement.html.twig');
    }
}
