<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]

    public function index()
    {
        # l'objet Environment ($this->twig) possède une méthode render
        # qui permet d'afficher un template grâce à son chemin

        return ($this->render('home/index.html.twig', [
            'title' => 'Bienvenue sur Duckzon',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem quam cum corrupti modi 
                          cupiditate nostrum odit illo veniam, nulla neque officia expedita rerum, aliquid libero 
                          incidunt rem iusto reprehenderit maxime!',
            'date' => new \DateTime(),
        ]));
    }
}