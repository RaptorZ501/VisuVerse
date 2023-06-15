<?php

namespace App\Controller;

use App\Entity\CssModifer;
use App\Form\CssModiferType;
use App\Repository\CssModiferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/css/modifer')]
class CssModiferController extends AbstractController
{
    #[Route('/', name: 'app_css_modifer_index', methods: ['GET'])]
    public function index(CssModiferRepository $cssModiferRepository): Response
    {
        return $this->render('css_modifer/index.html.twig', [
            'css_modifers' => $cssModiferRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_css_modifer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CssModiferRepository $cssModiferRepository): Response
    {
        $cssModifer = new CssModifer();
        $form = $this->createForm(CssModiferType::class, $cssModifer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cssModiferRepository->save($cssModifer, true);

            return $this->redirectToRoute('app_css_modifer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('css_modifer/new.html.twig', [
            'css_modifer' => $cssModifer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_css_modifer_show', methods: ['GET'])]
    public function show(CssModifer $cssModifer): Response
    {
        return $this->render('css_modifer/show.html.twig', [
            'css_modifer' => $cssModifer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_css_modifer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CssModifer $cssModifer, CssModiferRepository $cssModiferRepository): Response
    {
        $form = $this->createForm(CssModiferType::class, $cssModifer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cssModiferRepository->save($cssModifer, true);

            return $this->redirectToRoute('app_css_modifer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('css_modifer/edit.html.twig', [
            'css_modifer' => $cssModifer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_css_modifer_delete', methods: ['POST'])]
    public function delete(Request $request, CssModifer $cssModifer, CssModiferRepository $cssModiferRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cssModifer->getId(), $request->request->get('_token'))) {
            $cssModiferRepository->remove($cssModifer, true);
        }

        return $this->redirectToRoute('app_css_modifer_index', [], Response::HTTP_SEE_OTHER);
    }
}
