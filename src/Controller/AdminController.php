<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
use App\Repository\FillierRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository,EtudiantRepository $etudiantRepository,FillierRepository $fillierRepository): Response
    {
        $fillier=$fillierRepository->findAll();
        $countfillier = $this->Count($fillier);
        $etudiant=$etudiantRepository->findAll();
        $countetudiant = $this->Count($etudiant);
        $admin = $userRepository->findByRole("ROLE_ADMIN");
        $countadmin = $this->Count($admin);

        $somme=$etudiantRepository->findScolariterterTotal();
        dd($somme);
        return $this->render('admin/index.html.twig',[
            'countfillier'=>count($countfillier),
            'countetudiant'=>count($countetudiant),
            'countadmin'=>count($countadmin)]);
    }

    #[Route('/statistique', name: 'app_statistique', methods: ['GET'])]
    public function stat(): Response
    {
        return $this->render('home/statistique.html.twig', [
        ]);
    }



    /**
     * @param array $pub
     * @return array
     */
    protected function Count(array $pub): array
    {
        $countPub = [];
        foreach ($pub as $as) {
            $countPub[] = $as->getId();
        }
        return $countPub;
    }
}
