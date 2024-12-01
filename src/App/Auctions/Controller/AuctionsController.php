<?php

declare(strict_types=1);

namespace App\App\Auctions\Controller;

use App\Repository\DoctrineAuctionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final  class AuctionsController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(DoctrineAuctionRepository $repository): Response
    {
        $auctions = $repository->findRunningAuctions();

        return $this->render('home.html.twig', [
            'auctions' => $auctions,
        ]);
    }
}
