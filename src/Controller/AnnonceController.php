<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;

class AnnonceController extends AbstractController
{


    #[Route('/annonce')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
//        // rechercher une annonce par ID
//        $annonce = $annonceRepository->find(1);
//
//
//        // recherche toutes les annonces
//        $annonce = $annonceRepository->findAll();
//
//        // recherche une annonce par champ
//        $annonce = $annonceRepository->findOneBy(['sold' => false]);

        $annonces = $annonceRepository->findLatestNotSold();

        return $this->render('annonce/index.html.twig', [
            'title' => 'Bienvenue sur Duckzon',
            'annonces' => $annonces
        ]);
    }

    #[Route('/annonce/new')]
    public function new(ManagerRegistry $doctrine)
    {
        $annonce = new Annonce();
        $annonce
            ->setTitle('Chien')
            ->setDescription('Vends car plus d\'utilité')
            ->setPrice(1200)
            ->setStatus(Annonce::STATUS_GOOD)
            ->setSold(false)
            ->setSlug('Vends Super Canard trouvé en boulangerie-pâtisserie')
        ;

        // On récupère l'EntityManager
        $em = $doctrine->getManager();
        // On « persiste » l'entité
        $em->persist($annonce);
        // On envoie tout ce qui a été persisté avant en base de données
        $em->flush();

        die ('annonce bien créée');

    }

    #[Route('/annonce/{id}')]
    public function show(int $id, AnnonceRepository $annonceRepo)
    {
        $annonce = $annonceRepo->find($id);

        if(!$annonce)
        {
            $this->createNotFoundException();
        }

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce
        ]);
    }

    #[Route('/annonce/{slug}-{id}')]
    public function showBySlug(string $slug, int $id, AnnonceRepository $annonceRepository): Response
    {
        $annonce = $annonceRepository->findOneBy([
            'slug' => $slug,
            'id' => $id
        ]);

        if (!$annonce) {
            return $this->createNotFoundException();
        }

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

}
