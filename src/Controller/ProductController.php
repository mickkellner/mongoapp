<?php

namespace App\Controller;

use App\Document\Product;
use App\Form\ProductType;
use App\Document\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;


class ProductController extends AbstractController
{
    
    
    
    
    
    
    #[Route('/product/add', name: 'product_add')]
    public function add(DocumentManager $dm, Request $request, RequestStack $requestStack): Response
    {
        $form = $this->createForm(ProductType::class, new Product());

        $form->handleRequest($request);
        
        $session = $requestStack->getSession();
        $email = $session->get('_security.last_username');
       
         if ($form->isSubmitted() && $form->isValid()) {    
                                
            $product = $form->getData();           
            
            $user = $dm->getRepository(User::class)->findOneBy(['email' => $email]); 
                   
            $user->addProduct($product);
                       
            $dm->persist($user);
            $dm->persist( $product );
            
            $dm->flush();
            return $this->redirectToRoute('product_list');
        }
        
        return $this->render('product/index.html.twig', [

            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/list', name: 'product_list')]
    public function list(DocumentManager $dm, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $email = $session->get('_security.last_username');
        $user = $dm->getRepository(User::class)->findOneBy(['email' => $email]);
        $products = $user->getProducts();
        $dm->clear();
                
        return $this->render('/product/list.html.twig', [           
            'products' => $products,
        ]);
    }




    #[Route('/product/delete/{productId}', name: 'product_delete')]
    public function delete(DocumentManager $dm, $productId, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $email = $session->get('_security.last_username');
        $user = $dm->getRepository(User::class)->findOneBy(['email' => $email]);        
        $product = $user->getProductById($productId);
        $user->removeProduct($product);
        $dm->persist($user);     
        $dm->flush();
        $products = $user->getProducts();

        $this->addFlash( 'notice', 'Das Produkt wurde gelöscht!' );

        return $this->render('/product/list.html.twig', [
            'products' => $products,
        ]);
    }


}
