<?php

namespace App\Controller;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{

    #[Route('/', name: 'app_home', methods: ['GET','POST'])]
    public function home(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('main/home.html.twig');
    }

    #[Route('/test', name: 'app_test', methods: ['GET','POST'])]
    public function test(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('main/test.html.twig');
    }

}