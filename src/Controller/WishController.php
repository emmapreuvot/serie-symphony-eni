<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'app_wish')]
class WishController extends AbstractController
{
    #[Route('', name: 'app_wish_list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishlist = $wishRepository->findBy([],['dateCreated'=>'DESC']);
        return $this->render('wish/list.html.twig', ['wishlist'=>$wishlist
        ]);
    }

    #[Route('details/{id}', name: 'app_wish_details')]
    public function details(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        return $this->render('wish/details.html.twig', ['wish'=>$wish
        ]);
    }
}
