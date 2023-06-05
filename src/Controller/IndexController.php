<?php

namespace App\Controller;

use App\Entity\User;
use App\Controller\RoleController;
use App\Controller\SessionController;
use App\Entity\Onglet;
use App\Form\OngletType;
use App\Repository\OngletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Naming\OrignameNamer;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;




$session = new Session();
//$session->start();

class IndexController extends AbstractController
{

    private OrignameNamer $namingStrategy;
    private $sessionController;

    public function __construct(SessionController $sessionController, OrignameNamer $namingStrategy)
    {
        $this->sessionController = $sessionController;
        $this->namingStrategy = $namingStrategy;
    }

    use ServiceSubscriberTrait;


    /**
    * @paramConverter("onglet", options={"mapping": {"user_id": "id"}})
    */
    #[Route('/', name: 'app_index')]
    public function index(
                        EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, 
                        AuthorizationCheckerInterface $authorizationChecker,  
                        AuthenticationUtils $authenticationUtils,
                        Security $security,
                        request $request, SessionController $sessionController, 
                        OngletRepository $ongletRepository
                        ): Response
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

            //$onglet = $ongletRepository->findOneBy(['user' => $user->getOngletId()]);
            /*
            if (!$onglet) {
                // L'objet Onglet n'existe pas pour cet utilisateur, nous devons le créer
                $onglet = new Onglet();
                $onglet->setUser($user);

                // Effectuez d'autres opérations d'initialisation si nécessaire

                // Enregistrez l'objet Onglet dans la base de données
                $entityManager->persist($onglet);
                $entityManager->flush();
            }
            */
            // Utilisez l'objet User selon vos besoins
            $id = $user->getId();
            
            $onglet = new Onglet();
            $form = $this->createForm(OngletType::class, $onglet);
            $form->handleRequest($request);

            /*
            if ($form->isSubmitted() && $form->isValid()) { 

                $onglet->setUser($user);

                $ongletRepository->save($onglet, true);
                return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
            }*/



            //$session->set('id', $user->getId());
            $sessionId = $sessionController->getSessionid();



            return $this->render('index/index.html.twig', [
                'last_username' => $lastUsername, 
                'error' => $error,
                'ajout' => true,
                'sessionId' => $sessionId,
                //'form' => $form->createView(),
                'onglets' => $ongletRepository->findAll(),
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
