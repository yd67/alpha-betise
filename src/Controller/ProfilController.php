<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
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

     /**
     * @Route("/profil/update", name="profil_update")
     */
    public function updateProfil(UserRepository $userRepository, Request $request)
    {
        $userId = $this->getUser()->getId();
        $user = $userRepository->find($userId);
        //recuperer l'ancien image
        $oldNomImg = $user->getImg();
        $oldCheminImg = $this->getParameter('dossier_photos_user').'/'. $oldNomImg;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('img')->getData() !== null){ 
                if (file_exists($oldCheminImg)) {
                    unlink($oldCheminImg); 
                } 
                $infoImg = $form['img']->getData();
                $extensionImg = $infoImg->guessExtension();
                $nomImg = time() . '.' . $extensionImg;
                $infoImg->move($this->getParameter('dossier_photos_user'), $nomImg);
                $user->setImg($nomImg);    
            }else{
                $user->setImg($oldNomImg);
            }
        
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Les informations ont bien été modifié'
            );
            return $this->redirectToRoute('profil');
        }
        return $this->render('profil/updateProfil.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
}
