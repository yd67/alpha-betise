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
    public function index(EvenementsRepository $evenementsRepository,EventsParticipantRepository $eventsParticipantRepository): Response
    {
        $evenements = $evenementsRepository->findAll();
        $eventsParticipant = $eventsParticipantRepository->findAll();

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
        
        return $this->render('evenements/index.html.twig', [
            'evenements' => $evenementsAvenir,
            'donnees' => $donnees,
            // 'userEmail' => $userEmail,
            'participant' => $eventsParticipant
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
     * @Route("/evenements/list", name="evenements_list")
     */
    public function listEvenement(EvenementsRepository $evenementsRepository){
        $listEvents = $evenementsRepository->findOrderAll('DESC') ;
        
        return $this->render('admin/listEvenement.html.twig',[
            'listEvents' => $listEvents ,
        ]);
    } 

     /**
     * @Route("/evenements/inscrit-{id}", name="evenements_inscrit")
     */
    public function evenementInscrit($id,EventsParticipantRepository $eventsParticipant){

       $events = $eventsParticipant->findByE($id) ;
       

       return $this->render('admin/inscritEvenement.html.twig',[
        'events' => $events ,
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
     public function inscriptionEvenement($id,EventsParticipantRepository $eventsParticipantRepository, UserRepository $userRepository, EvenementsRepository $evenementsRepository){

        $participant= new EventsParticipant();
        $evenements = $evenementsRepository->find($id);

        // checher l'evenement lié a l'utisateur afin de verifier si il est deja inscrit a l'evnement
        $userId =$this->getUser()->getId();
        $eventId = $evenements->getId();
        $userP = $eventsParticipantRepository->findByPartication($eventId ,$userId);

        if($userP == null ){
            
                $user = $this->getUser();
                $participant->setUser($user);
                $participant->setEvenement($evenements);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($participant);
                $entityManager->flush();
                $this->addFlash(
                    'success',' inscription reussie '
                );

        }else{
        
            $this->addFlash(
                'warning',' vous etes deja inscrit pour cette evenement ! '
            );
        }
        return $this->redirectToRoute('evenements');
       

    }

     /**
     * @Route("/evenements/deinscription-{id}", name="evenements_desinscription")
     */
    public function desinscriptionEvenement($id, EventsParticipantRepository $eventsParticipantRepository,EvenementsRepository $evenementsRepository){

        $userId =$this->getUser()->getId();

        $event = $evenementsRepository->find($id);
        $eventId = $event->getId();

        $participation = $eventsParticipantRepository->findByPartication($eventId ,$userId);

        if($participation != null){

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($participation);
            $manager->flush();
    
            $this->addFlash(
                'success',' désinscription reussie '
            );
        }else{

            $this->addFlash(
                'warning','impossible de se désinscire, vous n\'etes pas inscrit a cette evements ! '
            );

        }

        return $this->redirectToRoute('profil');   
    }
    
}
