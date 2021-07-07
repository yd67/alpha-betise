<?php

namespace App\Controller;

use App\Repository\LivresRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session,LivresRepository $livresRepository): Response
    {
        $panier = $session->get('panier',[]);

        $monPanier = [] ;

        $total = 0 ;

        foreach( $panier as $id => $quantity ){
            
            $livres = $livresRepository->find($id);
            $monPanier[] = [
                'produit' => $livres ,
                'quantité' => $quantity,
            ];
 
            $total += $livres->getPrix() * $quantity ; 
        }

        return $this->render('commande/index.html.twig', [
            'panier' => $monPanier,
            'total' =>$total
        ]);
    }
     /**
     * @Route("/panier/add-{id}", name="panier_add")
     */
    public function addPanier($id,SessionInterface $session)
    {
        $panier = $session->get('panier',[]);

        if(!empty($panier[$id] )){
            
            $panier[$id]++ ;
        }else{
            $panier[$id] = 1 ;
        }

        $session->set('panier',$panier);
        
        return  $this->redirectToRoute('panier');


    }

     /**
     * @Route("/panier/remove-{id}", name="panier_remove")
     */
    public function remove($id,SessionInterface $session)
    {
        $panier = $session->get('panier',[]);

        if(($panier[$id] > 1) ){
            $panier[$id]-- ;
        }else{
            unset( $panier[$id]) ;
        }

        $session->set('panier',$panier);
        

       return $this->redirectToRoute('panier');

    }
     
}
