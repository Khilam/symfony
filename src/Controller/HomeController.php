<?php 

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SessionInterface $session,ArticleRepository $articleRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierwithdata = [];
        foreach($panier as $id => $quantity){
            $panierwithdata[]= [
            'article' => $articleRepository->find($id),
            'quantity' => $quantity
        ];
        }
     
      

        return $this->render('home/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
    /**
     * @Route("/panier/add/{id})", name="cart_add")
     */
    public function add($id, SessionInterface $session)
    {

        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            $panier[$id]++;

    } else{
       $panier[$id] = 1;
    
    }
       $session->set('panier', $panier);
       dd($session->get('panier'));

        }
}
