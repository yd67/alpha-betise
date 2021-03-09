<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EvenementsType;
use App\Repository\EvenementsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EvenementsController extends AbstractController
{
    /**
     * @Route("/evenements", name="evenements")
     */
    public function index(EvenementsRepository $evenementsRepository): Response
    {
        $evenements = $evenementsRepository->findAll();

        return $this->render('evenements/index.html.twig', [
            'controller_name' => 'EvenementsController',
            'evenements' => $evenements
        ]);
    }
    /**
     * @Route("/evenements/create", name="evenements_creation")
     */
    public function createEvenements(Request $request){
        
        $evenements= new Evenements();
        $form = $this->createForm(EvenementsType::class, $evenements);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $infoImg = $form['img']->getData(); // récupère les infos de l'image 
            $extensionImg = $infoImg->guessExtension(); // récupère le format de l'image 
            $nomImg = time() . '.' . $extensionImg; // compose un nom d'image unique
            $infoImg->move($this->getParameter('dossier_photos_evenements'), $nomImg); // déplace l'image
            $evenements->setImg($nomImg);

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenements);
            $entityManager->flush();
           
            return $this->redirectToRoute('admin');

        }

        return $this->render('admin/ajoutEvenements.html.twig', [
            'createEvenementsForm' => $form->createView(),
        ]);
        
    }
}
