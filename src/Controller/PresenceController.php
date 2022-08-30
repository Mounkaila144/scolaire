<?php

namespace App\Controller;

use App\Entity\Presence;
use App\Form\PresenceType;
use App\Repository\EtudiantRepository;
use App\Repository\FillierRepository;
use App\Repository\PresenceRepository;
use App\Repository\ProfRepository;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/presence')]
class PresenceController extends AbstractController
{
    //liste des etudiants dans la liste de presence
    #[Route('/{pro}/{fil}/{refrech}', name: 'app_presence_index', methods: ['GET'], priority: -1)]
    public function index(int $pro, int $fil, PresenceRepository $presenceRepository, FillierRepository $fillierRepository,
                          EtudiantRepository $etudiantRepository, PromotionRepository $promotionRepository, SessionInterface $session, int $refrech = 0): Response
    {
        if ($refrech == 0) {
            $year = new \DateTime("$pro-01-01");
            $promo = $promotionRepository->findOneBy(["annee" => $year]);
            $fillier = $fillierRepository->find($fil);
            $etudiants = $etudiantRepository->findEtudiantByPromotionAndFillier($promo, $fillier);
            $data = [];
            foreach ($etudiants as $etudiant) {
                $id = $etudiant->getId();
                $id == null ?: $data[$id] = false;
            }
            $session->set("list", $data);
        }


        $list = $session->get("list", []);
        $data = [];
        foreach ($list as $id => $presence) {
            $etud = $etudiantRepository->find($id);
            $etud == null ?:
                $data[] = [
                    "etudiant" => $etudiantRepository->find($id),
                    "present" => $presence
                ];
        }
        return $this->render('presence/index.html.twig', [
            'etudiants' => $data,
            'pro' => $pro,
            'fil' => $fil
        ]);
    }

    //set present
    #[Route('/present/{id}/{pro}/{fil}', name: 'app_presence_present', methods: ['GET'])]
    public function present(int $id, int $pro, int $fil, PresenceRepository $presenceRepository, SessionInterface $session): Response
    {
        $liste = $session->get('list', []);
        $liste[$id] = true;
        $refrech = 1;
        $session->set("list", $liste);
        return $this->redirectToRoute("app_presence_index", compact('pro', 'fil', 'refrech'));
    }

    //set absent
    #[Route('/absent/{id}/{pro}/{fil}', name: 'app_presence_absence', methods: ['GET'])]
    public function absent(int $id, int $pro, int $fil, PresenceRepository $presenceRepository, SessionInterface $session): Response
    {
        $liste = $session->get('list', []);
        $liste[$id] = false;
        $refrech = 1;
        $session->set("list", $liste);
        return $this->redirectToRoute("app_presence_index", compact('pro', 'fil', 'refrech'));
    }

    //envoyer la liste des presences
    #[Route('/new/{pro}/{fil}', name: 'app_presence_new', methods: ['GET', 'POST'])]
    public function new($pro, int $fil, PromotionRepository $promotionRepository, FillierRepository $fillierRepository, Request $request, SessionInterface $session, PresenceRepository $presenceRepository, ProfRepository $profRepository): Response
    {
        $year = new \DateTime("$pro-01-01");
        $promo = $promotionRepository->findOneBy(["annee" => $year]);
        $prof = $profRepository->find($this->getUser()->getId());
        $list = $session->get('list', []);
        $presence = new Presence();
        $presence
            ->setListe($list)
            ->setDate(new \DateTime('now'))
            ->setProf($prof)
            ->setPromotion($promo)
            ->setFillier($fillierRepository->find($fil));
        $presenceRepository->add($presence, true);

        return $this->redirectToRoute('app_prof');
    }

    //liste des presences
    #[Route('/liste/{pro}/{fil}', name: 'app_presence_liste', methods: ['GET'])]
    public function liste(int                $pro, int $fil, PresenceRepository $presenceRepository, FillierRepository $fillierRepository,
                          EtudiantRepository $etudiantRepository, PromotionRepository $promotionRepository): Response
    {
        $year = new \DateTime("$pro-01-01");
        $promo = $promotionRepository->findOneBy(["annee" => $year]);
        $fillier = $fillierRepository->find($fil);
        $list = $presenceRepository->findPresenceByPromotionAndFillier($promo, $fil);
        return $this->render('presence/liste.html.twig', [
            'presences' => $list,
        ]);
    }

    #[Route('/listetudiants/{id}', name: 'app_presence_liste_etudiant', methods: ['GET'])]
    public function listetudiant(int $id, PresenceRepository $presenceRepository, FillierRepository $fillierRepository,
                          EtudiantRepository $etudiantRepository, PromotionRepository $promotionRepository): Response
    {
        $list = $presenceRepository->find($id)->getListe();
        $data=[];
        foreach ($list as $id => $presence) {
            $etud = $etudiantRepository->find($id);
            $etud == null ?:
                $data[] = [
                    "etudiant" => $etudiantRepository->find($id),
                    "present" => $presence
                ];
        }
        return $this->render('presence/listetudiants.html.twig', [
            'etudiants' => $data,
        ]);
    }


    #[Route('/{id}', name: 'app_presence_show', methods: ['GET'])]
    public function show(Presence $presence): Response
    {
        return $this->render('presence/show.html.twig', [
            'presence' => $presence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_presence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Presence $presence, PresenceRepository $presenceRepository): Response
    {
        $form = $this->createForm(PresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $presenceRepository->add($presence, true);

            return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('presence/edit.html.twig', [
            'presence' => $presence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presence_delete', methods: ['POST'])]
    public function delete(Request $request, Presence $presence, PresenceRepository $presenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $presence->getId(), $request->request->get('_token'))) {
            $presenceRepository->remove($presence, true);
        }

        return $this->redirectToRoute('app_presence_index', [], Response::HTTP_SEE_OTHER);
    }
}
