<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(SessionInterface $session, ProductRepository $repo): Response
    {
        $cart = $session->get('cart', []);
        $data = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $repo->find($id);

            if (!$product) continue;

            $data[] = [
                'product' => $product,
                'quantity' => $quantity
            ];

            $total += $product->getPriceHT() * $quantity;
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $data,
            'total' => $total
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(int $id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);

        unset($cart[$id]);

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }
}