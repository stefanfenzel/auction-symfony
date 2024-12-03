<?php

declare(strict_types=1);

namespace App\App\Auctions\Controller;

use App\App\Auctions\Form\AuctionFormType;
use App\Domain\Auctions\Auction;
use App\Domain\Uuid;
use App\Domain\UuidFactory;
use App\Infrastructure\Auctions\Repository\DoctrineAuctionRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AuctionsController extends AbstractController
{
    public function __construct(
        private readonly UuidFactory $uuidFactory,
        private readonly DoctrineAuctionRepository $repository,
    )
    {
    }

    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        $auctions = $this->repository->findRunningAuctions();

        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('home.html.twig', [
            'auctions' => $auctions,
        ]);
    }

    #[Route('/dashboard', name: 'dashboard')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function dashboard(): Response
    {
        $auctions = $this->repository->findRunningAuctions();

        return $this->render('dashboard.html.twig', [
            'auctions' => $auctions,
        ]);
    }

    #[Route('/auctions', name: 'auctions')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function auctions(): Response
    {
        $auctions = $this->repository->findByUserId($this->getUser()->getId());

        return $this->render('auctions/auctions.html.twig', [
            'auctions' => $auctions,
        ]);
    }

    #[Route('/auctions/{id}', name: 'auctions_show', requirements: ['id' => Requirement::UUID_V7])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(string $id): Response
    {
        $auction = $this->repository->findById(Uuid::fromString($id));

        return $this->render('auctions/show.html.twig', [
            'auction' => $auction,
        ]);
    }

    #[Route('/auctions/create', name: 'auctions_create')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(Request $request): Response
    {
        $auction = new Auction();
        $form = $this->createForm(AuctionFormType::class, $auction);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Auction $auction */
            $auction = $form->getData();
            $auction->setId($this->uuidFactory->create()->toString());
            $auction->setUser($this->getUser());
            $auction->setCreatedAt(new DateTimeImmutable());
            $auction->setUpdatedAt(new DateTimeImmutable());

            $this->repository->save($auction);

            return $this->redirectToRoute('auctions_show', ['id' => $auction->getId()]);
        }

        return $this->render('auctions/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/auctions/{id}/delete', name: 'auctions_delete', requirements: ['id' => Requirement::UUID_V7])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(string $id): Response
    {
        $auction = $this->repository->findById(Uuid::fromString($id));
        if ($auction instanceof Auction && $auction->getUser()->getId() !== $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $this->repository->delete(Uuid::fromString($id));

        return $this->redirectToRoute('auctions');
    }

    #[Route('/auctions/{id}/edit', name: 'auctions_edit', requirements: ['id' => Requirement::UUID_V7])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(string $id, Request $request): Response
    {
        $auction = $this->repository->findById(Uuid::fromString($id));
        if ($auction instanceof Auction && $auction->getUser()->getId() !== $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(AuctionFormType::class, $auction);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $auction->setUpdatedAt(new DateTimeImmutable());

            $this->repository->save($auction);

            return $this->redirectToRoute('auctions_show', ['id' => $auction->getId()]);
        }

        return $this->render('auctions/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
