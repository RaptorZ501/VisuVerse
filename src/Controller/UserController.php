<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserLoginType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Intl\Formatter\DateTimeFormatterInterface;
use Symfony\Component\HttpFoundation\Session\Session;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/admin', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        //session_start()
        $session = $request->getSession();

        // Récupérer la valeur de l'ID depuis la session
        $id = $session->get('id');


        return $this->render('user/membre.html.twig', [
            'users' => $userRepository->findAll(),
            'id' => $id
        ]);
    }
                                            //a voir si je doit modifier
    #[Route('/admin/{id}', name: 'app_user_role', methods: ['GET', 'POST'])]
    public function changeRole(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, 
                        AuthorizationCheckerInterface $authorizationChecker): Response
    {

        // Appel de la fonction changeUserRole()
        $this->changeUserRole($entityManager, $tokenStorage, $authorizationChecker);
    }

    public function changeUserRole(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
    
        // Récupérer l'utilisateur à partir de la base de données
        $user = $entityManager->getRepository(User::class)->findOneBy(['pseudo' => 'RaptorZ501']);
    
        if ($user) {
            // Changer les rôles de l'utilisateur
            $user->setRoles(['ROLE_ADMIN']);
    
            // Enregistrer les modifications dans la base de données
            $entityManager->flush();
        }
    
        // Récupérer le token d'authentification de l'utilisateur connecté
        $token = $tokenStorage->getToken();
    
        if ($token instanceof TokenInterface) {
            // Récupérer l'utilisateur à partir du token
            $user = $token->getUser();
    
            // Vérifier si l'utilisateur est authentifié et a les autorisations nécessaires pour changer les rôles
            if ($authorizationChecker->isGranted('ROLE_ADMIN')) {
                // Changer les rôles de l'utilisateur
                $user->setRoles(['ROLE_ADMIN']);
    
                // Mettre à jour le token d'authentification pour refléter les nouveaux rôles
                $tokenStorage->setToken($token);
            }
        }
    }


    #[Route('/peon/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/peon/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/peon/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
