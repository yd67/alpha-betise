<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Form\NoteType;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\NotesRepository;
use App\Repository\LivresRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentairesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConseilLectureController extends AbstractController
{
    /**
     * @Route("/lecture", name="conseil_lecture")
     */
    public function index(PaginatorInterface $paginator ,LivresRepository $livresRepository, CategoryRepository $categoryRepository,Request $request): Response
    {
        $donnees = $livresRepository->findAll();
        $category = $categoryRepository->findAll();

        // pagination avec knp paginator 

        $livres = $paginator->paginate(
            $donnees, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        6 /*limit per page*/
        );
        
        $filter = $request->get('category');
        // $cat = $categoryRepository->findByCat();

        if($request->isXmlHttpRequest()){

            return new JsonResponse([
                'content' =>  $this->renderView('conseil_lecture/contenue.html.twig', [
                        'livres' => $livres,
                     ])
            ]);

        }

        return $this->render('conseil_lecture/index.html.twig', [
            'livres' => $livres,
            'category' => $category,
        ]);
    }

     /**
     * @Route("/lecture/category-{{id}} ", name="livre_By_Cat")
     */
    public function livresByCategory(CategoryRepository $categoryRepository,$id,Request $request){

        $category = $categoryRepository->find($id);

          $t = $category->getLivres();
 
          if($request->isXmlHttpRequest()){
              
            return new JsonResponse([
                'content' =>  $this->renderView('conseil_lecture/livresByCat.html.twig', [
                        'livreCat' => $t,
                     ])
            ]);

          }
            return $this->redirectToRoute('home');

    }
     /**
     * @Route("/lecture/produit-{{id}} ", name="produit_details")
     */
    public function afficheLivresDetails($id ,NotesRepository $notesRepository ,LivresRepository $livresRepository,Request $request)
    {
        $livres = $livresRepository->find($id);

        $noteM = $notesRepository->note($id);

        
        $commentaire = new commentaires();
        $form = $this->createForm(CommentairesType::class,$commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $dateCreation= new \DateTime ;
            $commentaire->setCreatedAt($dateCreation);

            $userConnecter = $this->getUser();
            $commentaire->setUser($userConnecter);
        
            $commentaire->setLivres($livres);
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commentaire);
            $manager->flush();
            
            return $this->redirectToRoute('produit_details',['id' => $livres->getId()]);
        }
 
        $note = new Notes();
        $noteForm = $this->createForm(NoteType::class,$note);
        $noteForm->handleRequest($request);
        
        if($noteForm->isSubmitted() && $noteForm->isValid()){

            $userConect = $this->getUser();
            $note->setUser($userConect);
            $note->setLivre($livres);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($note);
            $manager->flush();
            return $this->redirectToRoute('produit_details',['id' => $livres->getId()]);
        }
        

        return $this->render('conseil_lecture/produitDetails.html.twig', [
            'livre' => $livres,
            'commentaire' => $form->createView(),
            'noteForm' => $noteForm->createView(),
            'noteM' => $noteM
        ]);


    }
}
