<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\CommandLine;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'order_create')]
    public function create(
        SessionInterface $session,
        ProductRepository $repo,
        EntityManagerInterface $em
    ): Response
    {
        // ⚡ Vérifier si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('warning', 'Vous devez être connecté pour passer une commande.');
            return $this->redirectToRoute('app_login');
        }

        $cart = $session->get('cart', []);
        if (empty($cart)) {
            return $this->redirectToRoute('cart_index');
        }

        // 👉 Création de la commande
        $order = new Order();
        $order->setCreatedAt(new \DateTime());
        $order->setValid(true);

        // Générer un numéro de commande unique
        $orderNumber = 'ORD-' . strtoupper(bin2hex(random_bytes(4))); // Ex: ORD-1A2B3C4D
        $order->setOrderNumber($orderNumber);

        // Lier la commande à l'utilisateur connecté
        $order->setUser($user);

        $em->persist($order);

        // 👉 Création des lignes de commande
        foreach ($cart as $id => $quantity) {
            $product = $repo->find($id);
            if (!$product) continue;

            $line = new CommandLine();
            $line->setProduct($product);
            $line->setQuantity($quantity);
            $line->setOrderNumb($order);

            $em->persist($line);
        }

        $em->flush();

        // 👉 Vider le panier
        $session->remove('cart');

        return $this->render('order/success.html.twig', [
            'orderNumber' => $orderNumber,
        ]);
    }
}