<?php

namespace App\Controller;

use PhpParser\Node\Stmt\Return_;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,Request $request,UserRepository $repo): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        if($request->getSession()->get(Security::LAST_USERNAME, '')){
            $user = $repo->findOneByemail($request->getSession()->get(Security::LAST_USERNAME, ''));
            $request->getSession()->set('user',$user);
            if( $request->getSession()->get('user')!== null){
            if($request->getSession()->get('user')->getRole()=='admin'){
                return $this->redirect('/dashboard');
            }
            if($request->getSession()->get('user')->getRole()=='visiteur' || $request->getSession()->get('user')->getRole()=='artiste'){
                return $this->redirect('/');
            }
        }
        }

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Request $request): Response
    {
        $request->getSession()->set('user',null);
        return $this->redirect('/');
    }
}
