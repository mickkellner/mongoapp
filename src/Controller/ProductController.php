<?php

namespace App\Controller;

use App\Document\User;
use App\Document\Product;
use App\Form\Type\ProductType;
use App\Service\FileUploader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class ProductController extends AbstractController   
{    
    
    #[Route('/product/add', name: 'product_add')]
    public function add(DocumentManager $dm, Request $request, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ProductType::class, new Product());

        $form->handleRequest($request);        
        $user = $this->getUser();
        $product = new Product();
       
         if ($form->isSubmitted() && $form->isValid()) {    
                                
            $product = $form->getData();  
            
            /** @var UploadedFile $brochureFile */
            $coverFile = $form->get('cover')->getData();

            
            if ($coverFile) {
                $coverFileName = $fileUploader->upload($coverFile);
                $product->setCover($coverFileName);
            }else {
                return new FileException('Das Bild konnte nicht hochgeladen werden!');
            }

            $user->addProduct($product);        

            $dm->persist($user);
            $dm->persist( $product );            
            $dm->flush();
            $dm->clear();
            return $this->redirectToRoute('product_list');
        }    
        
        return $this->render('product/index.html.twig', [
             'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/list', name: 'product_list')]
    public function list(DocumentManager $dm): Response
    {
        $user = $this->getUser();
        
        $products = $user->getProducts();
        $dm->clear();
                
        return $this->render('/product/list.html.twig', [           
            'products' => $products,
        ]);
    }




    #[Route('/product/delete/{productId}', name: 'product_delete')]
    public function delete(DocumentManager $dm, $productId): Response
    {
        $user = $this->getUser();   
        $product = $user->getProductById($productId);
        $user->removeProduct($product);
        $dm->persist($user);     
        $dm->flush();
        $this->addFlash( 'notice', 'Das Produkt wurde entgültig gelöscht und kann nicht wieder hergestellt werden!' );
        $products = $user->getProducts();

        return $this->render('/product/list.html.twig', [
            'products' => $products,
        ]);
    }


    #[Route('/product/edit/{productId}', name: 'product_edit')]
    public function edit($productId, DocumentManager $dm, Request $request): Response
    {
        $user = $this->getUser();    
        $product = $user->getProductById($productId);

        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
                
       
         if ($form->isSubmitted() && $form->isValid()) {    
                                
            $product = $form->getData();
            //$product->setCover(new File($this->getParameter('covers_directory').'/'.$product->getCover()));

            $product->setId($productId);
            $dm->persist($product);
            $dm->flush();
            return $this->redirectToRoute('product_list'); 
        }
        
        return $this->render('product/index.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);


        

    }


}
