<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProductType;
use App\Entity\Product;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function index(ProductRepository $repo): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repo->findAll()
        ]);
    }

    
    #[Route('/product/create', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit créé avec succès !');
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
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
