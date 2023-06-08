<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Onglet;
use App\Form\OngletType;
use App\Repository\OngletRepository;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            ]);

        }

    #[Route(path: '/peon/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Fermer la session en invalidant ou en effaçant les données de session
        $session->invalidate(); // ou $session->clear();

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
