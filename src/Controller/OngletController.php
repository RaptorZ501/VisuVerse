<?php

namespace App\Controller;

use App\Entity\Onglet;
use App\Form\OngletType;
use App\Repository\OngletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/new', name: 'app_onglet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OngletRepository $ongletRepository): Response
    {
        $onglet = new Onglet();
        $form = $this->createForm(OngletType::class, $onglet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ongletRepository->save($onglet, true);

            return $this->redirectToRoute('app_onglet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('onglet/new.html.twig', [
            'onglet' => $onglet,
            'form' => $form,
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
        $form = $this->createForm(OngletType::class, $onglet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ongletRepository->save($onglet, true);

            return $this->redirectToRoute('app_onglet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('onglet/edit.html.twig', [
            'onglet' => $onglet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_onglet_delete', methods: ['POST'])]
    public function delete(Request $request, Onglet $onglet, OngletRepository $ongletRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$onglet->getId(), $request->request->get('_token'))) {
            $ongletRepository->remove($onglet, true);
        }

        return $this->redirectToRoute('app_onglet_index', [], Response::HTTP_SEE_OTHER);
    }
}
