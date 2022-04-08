<?php

namespace App\Controller;

use App\Document\Profile;
use App\Form\Type\ProfileType;
use App\Repository\ProfileRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfileController extends AbstractController
{
    
    
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
       
    }
    
    
    
    #[Route('/profile/add', name: 'profile_add')]
    public function add(Request $request): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile();
        
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted() && $form->isValid() )
        {            
            $profile = $form->getData();            
            $user->setProfile($profile);
            try{
                $this->dm->persist($user);
                $this->dm->flush();
            }catch(MongoDBException $e){
                return $e->getMessage();
            }
            $this->addFlash('success', 'Die Profildaten wurden gespeichert!');            
            return $this->redirectToRoute('app_home');
        }       
        return $this->render('profile/add.html.twig', [
            'profile_form' => $form->createView(),
            'user' => $user,
        ]);
    }


    #[Route('/profile/show', name: 'profile_show')]
    public function show(): Response
    {   
        $profile = $this->getUser();
        //dd($userProfile);
        
        return $this->render('profile/show.html.twig', [
            'user' => $profile,
        ]);
    }
}
