<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
use App\Repository\FillierRepository;
use App\Repository\PromotionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/{pro}', name: 'app_admin')]
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
        $nbretudiant=$fillierRepository->findByNiveau(3,$promo);
        $fraisNiveau=$fillierRepository->findOneBy(['niveau'=>3])->getScolariterApayer();
        $Apayer3=$fraisNiveau*$nbretudiant;
        $nbretudiant=$fillierRepository->findByNiveau(1,$promo);
        $fraisNiveau=$fillierRepository->findOneBy(['niveau'=>1])->getScolariterApayer();
        $Apayer1=$fraisNiveau*$nbretudiant;
        $nbretudiant=$fillierRepository->findByNiveau(2,$promo);
        $fraisNiveau=$fillierRepository->findOneBy(['niveau'=>2])->getScolariterApayer();
        $Apayer2=$fraisNiveau*$nbretudiant;
        $Apayertotal=$Apayer1+$Apayer2+$Apayer3;
        if ($Apayertotal==0){
            $Apayertotal=1;
        }
        //le pourcentage
        $pourcentage=number_format((100*$payer)/$Apayertotal,2);

        $promotion=$promotionRepository->findAll();


        return $this->render('admin/index.html.twig',[
            'countfillier'=>count($countfillier),
            'countetudiant'=>count($countetudiant),
            'countadmin'=>count($countadmin),
            'pourcentage'=>$pourcentage,
            'promotions'=>$promotion,
            'filliers'=>$fillierbypromo,
        ]);
    }

   #[Route('/admin/fillier/{pro}', name: 'app_admin_fillier')]
    public function fillier(EtudiantRepository $etudiantRepository,
                          FillierRepository $fillierRepository,PromotionRepository $promotionRepository,$pro="2022"): Response
    {
        $year=new \DateTime("$pro-01-01");
        $promo=$promotionRepository->findOneBy(["annee"=>$year]);
        $payer=$etudiantRepository->findScolariterterTotalByPromotionAndFillier($promo,);

        $fillier=$fillierRepository->findAll();
        $countfillier = $this->Count($fillier);
        $etudiant=$etudiantRepository->findEtudiantByPromotion($promo);
        $countetudiant = $this->Count($etudiant);
        $admin = $userRepository->findByRole("ROLE_ADMIN");
        $countadmin = $this->Count($admin);

        $nbretudiant=$fillierRepository->findByNiveau(3);
        $fraisNiveau=$fillierRepository->findOneBy(['niveau'=>3])->getScolariterApayer();
        $Apayer3=$fraisNiveau*$nbretudiant;
        $nbretudiant=$fillierRepository->findByNiveau(1);
        $fraisNiveau=$fillierRepository->findOneBy(['niveau'=>1])->getScolariterApayer();
        $Apayer1=$fraisNiveau*$nbretudiant;
        $nbretudiant=$fillierRepository->findByNiveau(2);
        $fraisNiveau=$fillierRepository->findOneBy(['niveau'=>2])->getScolariterApayer();
        $Apayer2=$fraisNiveau*$nbretudiant;
        $Apayertotal=$Apayer1+$Apayer2+$Apayer3;
        $pourcentage=number_format((100*$payer)/$Apayertotal,2);
        $promotion=$promotionRepository->findAll();


        return $this->render('admin/fillier.html.twig',[
            'countfillier'=>count($countfillier),
            'countetudiant'=>count($countetudiant),
            'countadmin'=>count($countadmin),
            'pourcentage'=>$pourcentage,
            'promotions'=>$promotion
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
