<?php

namespace App\Controller;

use App\Repository\LivresRepository;
use App\Repository\CategoryRepository;
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
    public function index(LivresRepository $livresRepository,CategoryRepository $categoryRepository,Request $request): Response
    {
        $livres = $livresRepository->findAll();
        $category = $categoryRepository->findAll();
        
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
    public function livresByCategory(CategoryRepository $categoryRepository,$id){

        $category = $categoryRepository->find($id);

          $t = $category->getLivres();
          
         
            return new JsonResponse([
                'content' =>  $this->renderView('conseil_lecture/livresByCat.html.twig', [
                        'livreCat' => $t,
                     ])
            ]);
        

        //   return $this->json([
        //       "lbycat" => $t ,
        //   ],200);
        // $response = array( 
        //     "code" => 200,
        //     "response" => $this->render('conseil_lecture/livresByCat.html.twig')->getContent() );

        // return new JsonResponse([
        //     'content' =>  $this->renderView('conseil_lecture/livresByCat.html.twig', [
        //             'livreCat' => $t,
        //          ])
        // ]);
        // return new JsonResponse([
        //     'code' => 200,
        //      'category' => $t
        // ],200);
        
        // return $this->renderView('conseil_lecture/livresByCat.html.twig', [
        //     'livreCat' => $t,
        // ]);

    }
}
