<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use App\Repository\ComplementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;




#[Route('/products')]
class ProductsController extends AbstractController

{
    #[Route('/{id}/details', name: 'app_prd_details')]
    public function prd(Products $product ):Response
    {
   
        return $this->render('products/afficherPr.html.twig', [
            'product' => $product,
        ]);
    }
    
    
    
    #[Route('/medicaments', name: 'medicament')]
    public function medicament(ProductsRepository $productsRepository ):Response
    {
   
        $products = $productsRepository->findAll();
        return $this->render('medicament.html.twig' ,[
         'products' => $products
            
        ]);
    }
  

    #[Route('/admin', name: 'app_products_index', methods: ['GET'])]
    public function index(ProductsRepository $productsRepository):Response
    {
        $products = $productsRepository->findAll();
        return $this->render('products/index.html.twig' ,[
         'products' => $products
            
        ]);
    }
    #[Route('/contact', name: 'contact', methods: ['GET'])]
    public function contact()
    {
        
        return $this->render('products/contact.html.twig' ,[
  
            
        ]);
    }

    #[Route('/acceuil', name: 'acceuil', methods: ['GET'])]
    public function acceuil(ComplementsRepository $complementsRepository): Response
    {
        $complements= $complementsRepository->findAll();
        return $this->render('products/acceuil.html.twig'  ,[
            'complements' => $complements
               
           ]);
    }


   
   


    #[Route('/new', name: 'app_products_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductsRepository $productsRepository,EntityManagerInterface $entityManager): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // traitement de l'upload de l'image
        
        
        $entityManager->persist($product);
        $entityManager->flush();

            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_products_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

   

    #[Route('/{id}/edit', name: 'app_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Products $product, ProductsRepository $productsRepository): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productsRepository->save($product, true);

            return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

   
    #[Route('/{id}', name: 'app_products_delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, ProductsRepository $productsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productsRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    }
    
   
   
}
