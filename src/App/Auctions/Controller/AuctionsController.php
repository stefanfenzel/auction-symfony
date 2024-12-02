<?php

declare(strict_types=1);

namespace App\App\Auctions\Controller;

use App\Domain\Uuid;
use App\Domain\UuidFactory;
use App\Infrastructure\Auctions\Repository\DoctrineAuctionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[Route('/dashboard', name: 'dashboard')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function dashboard(DoctrineAuctionRepository $repository): Response
    {
        $auctions = $repository->findRunningAuctions();

        return $this->render('dashboard.html.twig', [
            'auctions' => $auctions,
        ]);
    }

    #[Route('/auctions', name: 'auctions')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function auctions(DoctrineAuctionRepository $repository): Response
    {
        $auctions = $repository->findByUserId($this->getUser()->getId());

        return $this->render('auctions/auctions.html.twig', [
            'auctions' => $auctions,
        ]);
    }

    #[Route('/auctions/{id}', name: 'auctions_show')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(string $id, DoctrineAuctionRepository $repository): Response
    {
        $auction = $repository->findById(Uuid::fromString($id));

        return $this->render('auctions/show.html.twig', [
            'auction' => $auction,
        ]);
    }
}
