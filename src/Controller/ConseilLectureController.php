<?php

namespace App\Controller;

use App\Repository\LivresRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConseilLectureController extends AbstractController
{
    /**
     * @Route("/conseil/lecture", name="conseil_lecture")
     */
    public function index(LivresRepository $livresRepository): Response
    {
        $livres = $livresRepository->findAll();

        return $this->render('conseil_lecture/index.html.twig', [
            'livres' => $livres,
        ]);
    }
}
