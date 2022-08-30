<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Fillier;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use App\Repository\FillierRepository;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etudiant')]
class EtudiantController extends AbstractController
{
    #[Route('/', name: 'app_etudiant_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }
    #[Route('/byfillier/{id}/{pro}', name: 'app_etudiant_fillier', methods: ['GET'])]
    public function fillier(int $id,int $pro,EtudiantRepository $etudiantRepository,FillierRepository $fillierRepository,PromotionRepository $promotionRepository): Response
    {
        $year=new \DateTime("$pro-01-01");
        $promo=$promotionRepository->findOneBy(["annee"=>$year]);
        $fillier=$fillierRepository->find($id);
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findEtudiantByPromotionAndFillier($promo,$fillier),
        ]);
    }

    #[Route('/new', name: 'app_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EtudiantRepository $etudiantRepository): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etudiantRepository->add($etudiant, true);

            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EtudiantRepository $etudiantRepository): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etudiantRepository->add($etudiant, true);

            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/remove/{id}', name: 'app_etudiant_delete', methods: ['POST',"GET"])]
    public function delete(Request $request, Etudiant $etudiant, EtudiantRepository $etudiantRepository): Response
    {
            $etudiantRepository->remove($etudiant, true);


        return $this->redirectToRoute('app_etudiant_index');
    }
}
