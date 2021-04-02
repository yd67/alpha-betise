<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EvenementsType;
use App\Entity\EvensParticipants;
use App\Entity\EventsParticipant;
use App\Repository\UserRepository;
use App\Form\InscriptionEvenementsType;
use App\Repository\EvenementsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\EvensParticipantsRepository;
use App\Repository\EventsParticipantRepository;
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

        $test = $evenementsRepository->findAll();

        $rencontres = [];
                foreach($evenements as $evenements){
                $rencontres[] =[
                    'id'=> $evenements->getId(),
                    'start'=> $evenements->getStart()->format('Y-m-d H:i:s'),
                    'end'=> $evenements->getEnd()->format('Y-m-d H:i:s'),
                    'img'=> $evenements->getImg(),
                    'title'=> $evenements->getTitle(),
                    'lieux'=> $evenements->getLieux(),
                    'reservation'=> $evenements->getReservation(),
                    'max_personne'=> $evenements->getMaxPersonne(),
                    'prix'=> $evenements->getPrix(),
                    'age_cible'=> $evenements->getAgeCible(),
                    'backgroundColor'=> $evenements->getBackgroundColor(),
                    'textColor'=> $evenements->getTextColor(),
                ];
                }
            $donnees = json_encode($rencontres);

            // afficher les evenement a venir 
            $entityManager = $this->getDoctrine()->getManager();
            $dateA = new \DateTime('now') ;

            $query = $entityManager->createQuery("
            SELECT e FROM App\Entity\Evenements e WHERE e.end > :dateA 
            ")
            ->setParameter('dateA', $dateA)
            ->setMaxResults(2)
            ;

            $evenementsAvenir = $query->getResult() ;

            // recuperer un user conecter et son email
            $user = $this->getUser();
            if($user != null){
                 $userEmail = $user->getEmail() ;
            }else{
                $userEmail ="email inconu";
            }
            
        
        return $this->render('evenements/index.html.twig', [
            'evenements' => $evenementsAvenir,
            'donnees' => $donnees,
            'userEmail' => $userEmail,
        ] );
        
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

     /**
     * @Route("/evenements/passer", name="evenements_passer")
     */
    public function evenementPasser(){
        $entityManager = $this->getDoctrine()->getManager();

        $dateA = new \DateTime('now') ;
        
        $query = $entityManager->createQuery("
        SELECT e FROM App\Entity\Evenements e WHERE e.end < :dateA 
        ")
        ->setParameter('dateA', $dateA)
        ;

         $pass = $query->getResult() ;

        return $this->render('evenements/evenementsPasser.html.twig', [
               'events' => $pass ,
        ]);

    }

     /**
     * @Route("/evenements/inscription-{id}", name="evenements_inscription")
     */
     public function inscriptionEvenement($id, UserRepository $userRepository, EvenementsRepository $evenementsRepository){

        $participant= new EventsParticipant();

        $evenements = $evenementsRepository->find($id);

        $user = $this->getUser();
        $participant->setUser($user);
        $participant->setEvenement($evenements);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($participant);
        $entityManager->flush();

        return $this->redirectToRoute('evenements');


    }

    // public function inscriptionEvenement(Request $request){
    //     $participant = new EventsParticipant();
    //     $form = $this->createForm(InscriptionEvenementsType::class, $participant);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){

    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($participant);
    //         $entityManager->flush();
           
    //         return $this->redirectToRoute('evenements');
    //     }
    //     return $this->render('evenements/inscriptionEvenements.html.twig', [
    //         'inscriptionEvent' => $form->createView(),
    //     ]);

    // }


     /**
     * @Route("/evenements/deinscription-{id}", name="evenements_desinscription")
     */
    public function desinscriptionEvenement($id, EventsParticipantRepository $eventsParticipantRepository){

        $user = $this->getUser();
        $userId = $user->getId();

        $participant = $eventsParticipantRepository->findBy(array('id' => $userId )) ;

        dd($participant);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($participant);
        $manager->flush();

        $this->addFlash(
            'success','la categories a bien éte supprimer'
        );

        return $this->redirectToRoute('evenements');

        
    }
    
}
