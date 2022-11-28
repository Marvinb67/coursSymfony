<?php

namespace App\Controller;

use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;

class AnnonceController extends AbstractController
{


    #[Route('/annonce')]
    public function index(AnnonceRepository $annonceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $annonces = $paginator->paginate(
            $annonceRepository->findAllNotSoldQuery(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/annonce/new")
     *
     * @return void
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('app_annonce_index');
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView()
        ]);
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
