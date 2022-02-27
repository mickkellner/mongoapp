<?php

namespace App\Controller;

use App\Document\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager;


class ProductController extends AbstractController
{
    #[Route('/product/add', name: 'product_add')]
    public function addProduct(DocumentManager $dm, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, new Product());

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {           
                                
            $product = $form->getData();           
            
            $dm->persist( $product );
            $dm->flush();
            return $this->redirect('/home');
        }

        
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'form' => $form->createView(),

        ]);
    }
}
