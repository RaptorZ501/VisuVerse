<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\PageProject;
use App\Form\PageProjectType;
use App\Repository\PageProjectRepository;
use App\Entity\Onglet;
use App\Form\OngletType;
use App\Repository\OngletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[Route('{user}/projet')]
class PageProjectController extends AbstractController
{
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(PageProjectRepository $pageProjectRepository, User $user): Response
    {
        

        return $this->render('page_project/indexPageProject.html.twig', [
            'page_projects' => $pageProjectRepository->findAll(),
            'userId' => $user->getId(),
        ]);
    }

    #[Route('/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PageProjectRepository $pageProjectRepository, User $user): Response
    {
        $pageProject = new PageProject();
        $form = $this->createForm(PageProjectType::class, $pageProject);
        $form->handleRequest($request);
        $color = 'white';

        if ($form->isSubmitted() && $form->isValid()) {
            $pageProjectRepository->save($pageProject, true);

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('page_project/new.html.twig', [
            'page_project' => $pageProject,
            'form' => $form,
            'userId' => $user->getId(),
            'color' => $color,
        ]);
    }


    /**
    * @paramConverter("page_project", options={"mapping": {"id": "onglet_id_id"}})
    */
    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(PageProject $pageProject): Response
    {
        return $this->render('page_project/show.html.twig', [
            'page_project' => $pageProject,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_page_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PageProject $pageProject, PageProjectRepository $pageProjectRepository): Response
    {
        $form = $this->createForm(PageProjectType::class, $pageProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pageProjectRepository->save($pageProject, true);

            return $this->redirectToRoute('app_page_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('page_project/edit.html.twig', [
            'page_project' => $pageProject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_page_project_delete', methods: ['POST'])]
    public function delete(Request $request, PageProject $pageProject, PageProjectRepository $pageProjectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pageProject->getId(), $request->request->get('_token'))) {
            $pageProjectRepository->remove($pageProject, true);
        }

        return $this->redirectToRoute('app_page_project_index', [], Response::HTTP_SEE_OTHER);
    }
}
