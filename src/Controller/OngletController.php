<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Onglet;
use App\Form\OngletType;
use App\Repository\OngletRepository;
use App\Service\UserImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



#[Route('/onglet')]
class OngletController extends AbstractController
{
    #[Route('/', name: 'app_onglet_index', methods: ['GET'])]
    public function index(OngletRepository $ongletRepository): Response
    {
        return $this->render('onglet/index.html.twig', [
            'onglets' => $ongletRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new', name: 'app_onglet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OngletRepository $ongletRepository, User $user,
                        UserImageUploader $uploader): Response
    {

        $label = 'Choisissez une image';
        $onglet = new Onglet();
        $form = $this->createForm(OngletType::class, $onglet);
        $form->handleRequest($request);
       

        if ($form->isSubmitted() && $form->isValid()) {
            $onglet->setUser($user);
            $file = $form->get('imageFile')->getData();
        
            if($file){
                // Récupérer l'utilisateur actuellement connecté ou les informations nécessaires
                // pour créer un dossier individuel pour l'utilisateur

                $pseudo = $user->getPseudo();
                $title = $onglet->getTitle();
                $id = $onglet->getId();

                // Définir le nom du dossier utilisateur
                $userDirectory = 'dossier_' . $pseudo; // Par exemple, "1_johndoe"

                // Définir le chemin complet du dossier utilisateur
                $userFolderPath = 'img/projet/' . $userDirectory; // Remplacez "/path/to/images/" 
                                                                    // par le chemin réel vers le répertoire où vous souhaitez stocker les images
                $fileName = $file->getClientOriginalName();
                $filePath = $userFolderPath . $fileName;


                // Vérifier si le dossier utilisateur existe, sinon le créer
                if (!file_exists($userFolderPath)) {
                    mkdir($userFolderPath, 0777, true);
                }

                
            }

            $file->move($userFolderPath, $fileName);

            $ongletRepository->save($onglet, true);

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('onglet/tabForm.html.twig', [// onglet/tabAjout.html.twig
            'onglet' => $onglet,
            'form' => $form,
            'label' => $label,
        ]);
    }

    #[Route('/{id}', name: 'app_onglet_show', methods: ['GET'])]
    public function show(Onglet $onglet): Response
    {
        return $this->render('onglet/show.html.twig', [
            'onglet' => $onglet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_onglet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Onglet $onglet, OngletRepository $ongletRepository): Response
    {
        $label = 'Choisissez une image';
        $form = $this->createForm(OngletType::class, $onglet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ongletRepository->save($onglet, true);

            return $this->redirectToRoute('app_onglet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('onglet/edit.html.twig', [
            'onglet' => $onglet,
            'form' => $form,
            'label' => $label,
        ]);
    }

    /**
    * @ParamConverter("post", options={"id" = "id"})
    */
    #[Route('/{id}', name: 'app_onglet_delete', methods: ['POST'])]
    public function delete(Request $request, Onglet $onglet, OngletRepository $ongletRepository,
                            Security $security,): Response
    {

        if ($this->isCsrfTokenValid('delete'.$onglet->getId(), $request->request->get('_token'))) {
            $ongletRepository->remove($onglet, true);
        }
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();
            // Utilisez l'objet User selon vos besoins
            $id = $user->getId();
            return $this->redirectToRoute('app_index_co', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        /*return $this->redirectToRoute('app_index_co', [], Response::HTTP_SEE_OTHER);*/
    }
}
