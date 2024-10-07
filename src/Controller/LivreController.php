<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    #[Route('/le-leadership-de-kirikou', name: 'app_kirikou')]
    public function kirikou(): Response
    {
        return $this->render('livre/kirikou.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }
     #[Route('/le-pouvoir-de-se-reveiller-tot', name: 'app_pouvoir')]
    public function pouvoir(): Response
    {
        return $this->render('livre/pouvoir.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }
}
