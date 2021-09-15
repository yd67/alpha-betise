<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Entity\Category;
use App\Form\LivresType;
use App\Form\AjoutCategoryType;
use App\Repository\UserRepository;
use App\Repository\LivresRepository;
use App\Repository\VisiteRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request,PaginatorInterface $paginator,UserRepository $UserRepository,VisiteRepository $visiteRepo ,LivresRepository $livresRepository ,CategoryRepository $categoryRepository): Response
    {

        $donnees = $UserRepository->findNewUser();
        $category =$categoryRepository->findAll();
        $livres = $livresRepository->findAll();

        $users = $paginator->paginate(
            $donnees, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        4 /*limit per page*/
        );
        
        $visite = $visiteRepo->findAll();

        return $this->render('admin/admin.html.twig', [
            'users' => $users,
            'categories' => $category,
            'livres' =>$livres ,
            'visite' => $visite
        ]);
    }
     /**
     * @Route("/admin/user", name="user_list")
     */
    public function userList(UserRepository $UserRepository)
    {
        $users = $UserRepository->findAll();

        return$this->render('admin/userList.html.twig',[
            'users' => $users,
        ]);
    }

     /**
     * @Route("/admin/livres", name="livres_list")
     */
    public function livresList(Request $request,PaginatorInterface $paginator,LivresRepository $livresRepository)
    {
        $donnees= $livresRepository->findAll();

        $livres = $paginator->paginate(
            $donnees, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        5 /*limit per page*/
        );

        return$this->render('admin/livresList.html.twig',[
            'livres' => $livres,
        ]);
    }

    /**
     * @Route("/admin/livres/ajouter", name="ajout_livres")
     */
    public function ajouterLivres(Request $request)
    {
        $livres = new Livres ();
        $form = $this->createForm(LivresType::class, $livres);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){

            //gestion des images 
            $infoImg = $form['img']->getData(); // récupère les infos de l'image 
            $extensionImg = $infoImg->guessExtension(); // récupère le format de l'image 
            $nomImg = time() . '.' . $extensionImg; // compose un nom d'image unique
            $infoImg->move($this->getParameter('dossier_photos_livres'), $nomImg); // déplace l'image
            $livres->setImg($nomImg);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livres);
            $entityManager->flush();
           
            return $this->redirectToRoute('admin');
        }  

        return $this->render('admin/ajoutLivres.html.twig', [
            'ajoutForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/livres/modifier-{id}", name="modifier_livres")
     */
    public function modifierLivres($id,Request $request,LivresRepository $livresRepository)
    {
        $livres = $livresRepository->find($id);
         //recuperer l'ancien image
         $oldNomImg = $livres->getImg();
         $oldCheminImg = $this->getParameter('dossier_photos_livres').'/'. $oldNomImg;

         $form = $this->createForm(LivresType::class, $livres);
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
                if ($form->get('img')->getData() !== null){ 
                        if (file_exists($oldCheminImg)) {
                            unlink($oldCheminImg); 
                        } 
                        $infoImg = $form['img']->getData();
                        $extensionImg = $infoImg->guessExtension();
                        $nomImg = time() . '.' . $extensionImg;
                        $infoImg->move($this->getParameter('dossier_photos_livres'), $nomImg);
                        $livres->setImg($nomImg);    
                }else{
                    $livres->setImg($oldNomImg);
                }
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($livres);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Les informations ont bien été modifié'
                );
                return $this->redirectToRoute('livres_list');
            }

        return $this->render('admin/updateLivres.html.twig', [
            'livresForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/ajout/category", name="ajout_category")
     */
    public function ajoutCategory(Request $request)
    {

        $category = new Category();
        $formCategory = $this->createForm(AjoutCategoryType::class, $category);
        $formCategory->handleRequest($request);

        if($formCategory->isSubmitted() && $formCategory->isValid()){

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($category) ;
          $entityManager->flush();
          return $this->redirectToRoute('admin');
        }

        return $this->render('admin/ajoutCategory.html.twig', [
            'category' => $formCategory->createView(),
        ]);
    
    }
    
    /**
     * @Route("/admin/category/delete-{id}", name="delete_category")
     */
    public function deleteCategory(CategoryRepository $categoryRepository, $id)
    {

        $category = $categoryRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($category);
        $manager->flush();

        $this->addFlash(
            'success','la categories a bien éte supprimer'
        );

        return $this->redirectToRoute('admin');
    }
    
    /**
     * @Route("/admin/livre/delete-{id}", name="delete_livre")
     */
    public function deletelivre(LivresRepository $LivresRepository, $id)
    {

        $livres = $LivresRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($livres);
        $manager->flush();

        $this->addFlash(
            'success','la livre a bien éte supprimer'
        );

        return $this->redirectToRoute('admin');
    }

   
    
}
