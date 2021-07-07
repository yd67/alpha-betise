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
}
