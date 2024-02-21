<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/series', name: 'app_serie_list_')]
class SerieController extends AbstractController
{
    #[Route('', name: 'list')]
    public function liste(SerieRepository $serieRepository): Response
    {
        $series = $serieRepository->findBestSeries();
        return $this->render('serie/list.html.twig', ["series"=>$series]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        return $this->render('serie/details.html.twig', ['serie'=>$serie]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Serie $serie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/create', name: 'create')]
    public function create(
        EntityManagerInterface $entityManager,
        Request $request): Response
    {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());
        $serie->setDateModified(new \DateTime());

        $serieForm = $this->createForm(SerieType::class,$serie);


        $serieForm->handleRequest($request);
        if($serieForm->isSubmitted() && $serieForm->isValid()){

            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success','Serie added :) !');
            return $this->redirectToRoute('app_serie_list_details',['id'=>$serie->getId()]);
        }

        return $this->render('serie/create.html.twig', [
    'serieForm'=>$serieForm->createView()
        ]);
    }


    #[Route('/demo', name: 'em_demo')]
    public function demo(EntityManagerInterface $entityManager): Response
    {
        //créer une instance
        $serie = new Serie();

        //hydrater toutes les propriétés
        $serie->setName('pif');
        $serie->setBackdrop('fghdh');
        $serie->setPoster('fghdh');
        $serie->setGenres('Drama');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime("- 1 year"));
        $serie->setLastAirDate(new \DateTime("- 6 months"));
        $serie->setOverview('blablabla');
        $serie->setVote(8.2);
        $serie->setPopularity(128.72);
        $serie->setStatus('Cancelled');
        $serie->setTmdbId(7451239);

        dump($serie);

        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);

        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->render('serie/create.html.twig');
    }
}
