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
    // Vérifie si l'utilisateur est connecté
    if (!$this->getUser()) {
        // Sauvegarder la page de destination dans la session
        $session->set('redirect_after_login', $this->generateUrl('order_create'));

        // Rediriger vers la page de login
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
    $orderNumber = 'ORD-' . strtoupper(bin2hex(random_bytes(4)));
    $order->setOrderNumber($orderNumber);
    $order->setUser($this->getUser());

    $em->persist($order);

    // 👉 Création des lignes
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

    // 👉 vider le panier
    $session->remove('cart');

    return $this->render('order/success.html.twig');
}
}