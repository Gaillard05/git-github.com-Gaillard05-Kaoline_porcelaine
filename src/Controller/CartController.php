<?php

namespace App\Controller;


use App\Service\Cart\CartService;
use App\Entity\Pictures;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */

    public function index(SessionInterface $session, ProductsRepository $productsRepository)
    {

        // $total = $cartService->getFullCart();
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {

            $panierWithData[] = [
                'products' => $productsRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;
        $totalItem = 0;

        // pour caleculé le sous total

        foreach ($panierWithData as $item) {

            $totalItem = $item['products']->getPrices() * $item['quantity'];

            $total += $totalItem;
        }

        // dd($panierWithData);

        return $this->render("cart/index.html.twig", [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name = "cart_add")
     */

    //  pour ajouté les products
    public function add($id, SessionInterface $session)
    {

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {

            $panier[$id] = 1;
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute("cart_index");

        dd($session->get('panier'));
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */

    //  pour supprimer 

    public function remove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute("cart_index");
    }
}



















// class CartController extends AbstractController
// {
//     /**
//      * @Route("/panier", name="cart_index")
//      */

//     public function index(CartService $cartService)
//     {
//         // $panierWithData = $cartService->getFullCart();

//         // $total = $cartService->getFullCart();

//         return $this->render("cart/index.html.twig", [
//             'items' =>  $cartService->getFullCart(),
//             'total' => $cartService->getFullCart()

//         ]);
//     }

//     /**
//      * @Route("/panier/add/{id}", name = "cart_add")
//      */

//     public function add($id, CartService $cartService)
//     {

//         $cartService->add($id);
//         return $this->redirectToRoute("cart/index.html.twig");
//     }

//     /**
//      * @Route("/panier/remove/{id}", name="cart_remove")
//      */

//     public function remove($id, CartService $cartService)
//     {
//         $cartService->remove($id);
//         return $this->redirectToRoute("cart/index.html.twig");
//     }
// }