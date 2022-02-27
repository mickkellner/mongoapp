<?php
namespace App\Controller;

use App\Document\User;
use App\Form\Model\Registration;
use App\Form\Type\RegistrationType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SSymfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\EventListener\UserProviderListener;

class AccountController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function createAction(DocumentManager $dm, Request $request, UserPasswordHasherInterface $pwdHasher): Response
    {
        $form = $this->createForm(RegistrationType::class, new Registration() );
        
        $form->handleRequest($request);       

            if ($form->isSubmitted() && $form->isValid()) {           
                                
                $registration = $form->getData(); 
                
                $user = $registration->getUser();                
                $hashedPassword = $pwdHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);
                
                $dm->persist( $user );
                $dm->flush();
                return $this->redirect('/home');
            }

            return $this->render('account/register.html.twig', [
                'form' => $form->createView(),
            ]);
    }
}
