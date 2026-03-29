<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function index(ProductRepository $repo): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repo->findAll()
        ]);
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id, ProductRepository $repo): Response
    {
        $product = $repo->find($id);

        if (!$product) {
            throw $this->createNotFoundException("Le produit avec l'id $id n'existe pas.");
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
