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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $UserRepository,VisiteRepository $visiteRepo ,LivresRepository $livresRepository ,CategoryRepository $categoryRepository): Response
    {

        $users = $UserRepository->findNewUser();
        $category =$categoryRepository->findAll();
        $livres = $livresRepository->findAll();
        
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
     * @Route("/admin/ajout/livres", name="ajout_livres")
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
