<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ContainerInterface;


class SessionController extends AbstractController
{        

    private Security $security;
    //protected $container;

    public function __construct(Security $security, ContainerInterface $container)
    {
        $this->security = $security;
        $this->container = $container;
    }

    //#[Route('/admin/session', name: 'app_session')]
    public function index(Request $request,EntityManagerInterface $entityManager, 
                        TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker,  
                        AuthenticationUtils $authenticationUtils): Response
    {    

    }            
    public function getSessionId(){    
        $request = $this->container->get('request_stack')->getCurrentRequest();
        // Vérifier si l'utilisateur est authentifié
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {        
            //session_start()
            $session = $request->getSession();
            ;
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();

            // Utilisez l'objet User selon vos besoins
            $id = $user->getId();
            $session->set('id', $user->getId());
            return $session->get('id');
        }   
    }
    public function getSessionUser(){    
        $request = $this->container->get('request_stack')->getCurrentRequest();
        // Vérifier si l'utilisateur est authentifié
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {        
            //session_start()
            $session = $request->getSession();
            ;
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();

            // Utilisez l'objet User selon vos besoins

            $session->set('user', $user->getPseudo());
            return $session->get('user');
        }   
    }
}
