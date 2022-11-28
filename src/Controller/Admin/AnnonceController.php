<?php

namespace App\Controller\Admin;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

# note la route qui sera préfixée pour chaque route du contrôleur
/**
 * @Route("/admin")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce")
     */
    public function index(AnnonceRepository $annonceRepository)
    {
        $annonces = $annonceRepository->findAll();
        return $this->render('admin/annonce/index.html.twig', [
            'annonces' => $annonces
        ]);
    }

    /**
     * @Route("/annonce/{id}", methods="DELETE")
     */
    public function delete(Annonce $annonce, EntityManagerInterface $em, Request $request)
    {
        if($this->isCsrfTokenValid('delete', $annonce->getId(), $request->get('_token')))
        {
            // on supprime l'annonce de l'ObjetManager
            $em->remove($annonce);
            // en envoie la requête en base de données
            $em->flush();
        }
        return $this->redirectToRoute('app_admin_annonce_index');
    }

    /**
     * @Route("/annonce/{id}/edit")
     */
    public function edit(Annonce $annonce, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Annonce modifiée avec succès');
            return $this->redirectToRoute('app_admin_annonce_index');
        }

        return $this->render('admin/annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView()
        ]);
    }


}
