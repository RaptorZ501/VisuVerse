<?php

namespace App\Controller;

use App\Entity\User;
use App\Controller\RoleController;
use App\Controller\SessionController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

$session = new Session();
$session->start();

class IndexController extends AbstractController
{

    private $sessionController;

    public function __construct(SessionController $sessionController)
    {
        $this->sessionController = $sessionController;
    }


    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, 
                        AuthorizationCheckerInterface $authorizationChecker,  
                        AuthenticationUtils $authenticationUtils,
                        Security $security,
                        request $request, SessionController $sessionController): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //session_start()
        //$session = $request->getSession();

        // Vérifier si l'utilisateur est authentifié
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();
            

            // Utilisez l'objet User selon vos besoins
            $id = $user->getId();
            //$session->set('id', $user->getId());
            $sessionId = $sessionController->getSessionid();



            return $this->render('index/index.html.twig', [
                'last_username' => $lastUsername, 
                'error' => $error,
                'ajout' => true,
                //'id' => $id,
                'sessionId' => $sessionId 
            ]);
        }

        // Retourner une réponse par défaut si l'utilisateur n'est pas connecté
        return $this->render('index/index.html.twig', [
            'ajout' => false,
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/img/edit.png', name: 'app_img_edit')]
    public function imgEdit(): Response{
         return new Response();
    }
}
