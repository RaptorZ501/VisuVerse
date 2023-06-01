<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserLoginType;
use App\Form\ChangePasswordType;
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
            'id' => $id,
            'admin' => 'Administrateur',
            'membre' => 'Membre',
        ]);
    }

    #[Route('/peon/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles) ) {
            $rolesString = 'Administrateur';
        }
        elseif(in_array('ROLE_MEMBRE', $roles)){
            $rolesString = 'Membre';
        }

    
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'role' => $rolesString,
        ]);
    }

    #[Route('/peon/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $passwordForm = $this->createForm(ChangePasswordType::class);
        $passwordForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $updatedUser = $form->getData();

            // Accéder à la valeur des rôles
            $roles = $updatedUser->getRoles();

            // Convertir la valeur des rôles en tableau si elle est une chaîne de caractères
            if (is_string($roles)) {
                $roles = [$roles];
            }

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $formData = $form->getData();


            // Accéder aux valeurs des champs
            $oldPassword = $formData['oldPassword'];
            $newPassword = $formData['newPassword'];

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'passwordForm' => $passwordForm->createView(),
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
