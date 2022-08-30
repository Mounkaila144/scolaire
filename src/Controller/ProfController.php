<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
use App\Repository\FillierRepository;
use App\Repository\PromotionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfController extends AbstractController
{
    #[Route('/prof/{pro}', name: 'app_prof')]
    public function index(UserRepository $userRepository,EtudiantRepository $etudiantRepository,
                          FillierRepository $fillierRepository,PromotionRepository $promotionRepository,$pro="2022"): Response
    {
        //la somme totale de l'scolariter par promotion
        $year=new \DateTime("$pro-01-01");
        $promo=$promotionRepository->findOneBy(["annee"=>$year]);
        $payer=$etudiantRepository->findScolariterterTotalByPromotion($promo);
        //liste des fillier par promotion
        $fillierbypromo=$fillierRepository->findByPromotion($promo);

        //compter le total des fillier etudiant et Admin
        $fillier=$fillierRepository->findByPromotion($promo);
        $countfillier = $this->Count($fillier);
        $etudiant=$etudiantRepository->findEtudiantByPromotion($promo);
        $countetudiant = $this->Count($etudiant);
        $admin = $userRepository->findByRole("ROLE_ADMIN");
        $countadmin = $this->Count($admin);

        //Somme total payer par les filler
        $Apayertotal=0;
        foreach ($fillierRepository->findByPromotion($promo) as $fillier)
        {
            $Apayertotal+=$fillier->getScolariterApayer()*count($fillier->getEtudiants());
        }
        if ($Apayertotal==0){
            $Apayertotal=1;
        }

        //le pourcentage
        $pourcentage=number_format((100*$payer)/$Apayertotal,2);

        $promotion=$promotionRepository->findAll();


        return $this->render('admin/prof.html.twig',[
            'countfillier'=>count($countfillier),
            'countetudiant'=>count($countetudiant),
            'countadmin'=>count($countadmin),
            'pourcentage'=>$pourcentage,
            'promotions'=>$promotion,
            "pro"=>$pro,
            'filliers'=>$fillierbypromo,
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
