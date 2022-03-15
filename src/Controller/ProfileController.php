<?php

namespace App\Controller;

use App\Document\Profile;
use App\Document\User;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile_add')]
    public function add(DocumentManager $dm, Request $request): Response
    {
        $profile = new Profile();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);
        $email = $this->getUser()->getEmail();
        
        $repo = $dm->getRepository(User::class);
        $user = $repo->findOneBy(['email' => $email]);
        
        
        if($form->isSubmitted() && $form->isValid() )
        {
            
            $profile = $form->getData();
            
            $user->setProfile($profile);
            //dd($user);
            try{
                $dm->persist($user);
                $dm->flush();
            }catch(MongoDBException $e){
                return $e->getMessage();
            }
            $this->addFlash('success', 'Die Profildaten wurden gespeichert!');            
            return $this->redirectToRoute('app_home');
        }       
        
        return $this->render('profile/index.html.twig', [
            'profile_form' => $form->createView(),
        ]);
    }
}
