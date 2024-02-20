<?php

namespace App\Controller;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use function MongoDB\BSON\fromJSON;

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

        $serie = ["title" => "Game of thrones", "year"=> 2013];

        return $this->render('main/test.html.twig', ["mySerie"=>$serie]);
    }

    #[Route('/aboutus', name: 'app_about_us', methods: ['GET','POST'])]
    public function aboutus(SerializerInterface $serializer): \Symfony\Component\HttpFoundation\Response
    {
        $filePath = $this->getParameter('kernel.project_dir') . '/data/team.json';
        $jsonContent = file_get_contents($filePath);
        $aboutus = $serializer->decode($jsonContent, 'json');;
        return $this->render('main/aboutus.html.twig',['aboutus'=>$aboutus]);
    }

}