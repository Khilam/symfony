<?php 

namespace App\Controller;

use App\Controller\PanierController;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
/**
* @Route("/panier", name="cart_index")
*/
public function index(SessionInterface $session, ArticleRepository $articleRepository)
{
    $panier = $session->get('panier', []);

    $panierwithData = [];

    foreach($panier as $id => $quantity){
        $panierwithData[] = [
        'product' =>$articleRepository->find($id),
        'quantity' => $quantity
        ];
    }
  $total = 0;
  foreach($panierwithData as $item){
      $totalItem = $item['product']->getPrix() * $item['quantity'];
      $total += $totalItem;
  }
   return $this->render('panier/index.html.twig',['items' => $panierwithData,
'total' => $total]);

}
/**
 * @Route("/panier/add/{id}", name="cart_add")
 */

 public function add($id, SessionInterface $session){
    
     
     $panier = $session->get('panier', []);
     if(!empty($panier[$id])){
          $panier[$id]++;
     }else{

        $panier[$id] = 1;
     }

   

     $session->set('panier', $panier);
     dd($session->get('panier'));
 }

 /**
*@Route("/panier/remove/{id}", name="cart_remove")
*/
public function remove($id, SessionInterface $session){
$panier = $session->get('panier', []);
if(!empty($panier[$id])){
unset($panier[$id]);
}
$session->set('panier', $panier);
return $this->redirectToRoute("cart_index");
}
}

