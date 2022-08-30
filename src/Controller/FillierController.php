<?php

namespace App\Controller;

use App\Entity\Fillier;
use App\Form\FillierType;
use App\Repository\FillierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fillier')]
class FillierController extends AbstractController
{
    #[Route('/', name: 'app_fillier_index', methods: ['GET'])]
    public function index(FillierRepository $fillierRepository): Response
    {
        return $this->render('fillier/index.html.twig', [
            'filliers' => $fillierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fillier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FillierRepository $fillierRepository): Response
    {
        $fillier = new Fillier();
        $form = $this->createForm(FillierType::class, $fillier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fillierRepository->add($fillier, true);

            return $this->redirectToRoute('app_fillier_index');
        }

        return $this->renderForm('fillier/new.html.twig', [
            'fillier' => $fillier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fillier_show', methods: ['GET'])]
    public function show(Fillier $fillier): Response
    {
        return $this->render('fillier/show.html.twig', [
            'fillier' => $fillier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fillier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fillier $fillier, FillierRepository $fillierRepository): Response
    {
        $form = $this->createForm(FillierType::class, $fillier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fillierRepository->add($fillier, true);

            return $this->redirectToRoute('app_fillier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fillier/edit.html.twig', [
            'fillier' => $fillier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fillier_delete', methods: ['POST'])]
    public function delete(Request $request, Fillier $fillier, FillierRepository $fillierRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fillier->getId(), $request->request->get('_token'))) {
            $fillierRepository->remove($fillier, true);
        }

        return $this->redirectToRoute('app_fillier_index', [], Response::HTTP_SEE_OTHER);
    }
}
