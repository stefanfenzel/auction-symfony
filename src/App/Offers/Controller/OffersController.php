<?php

declare(strict_types=1);

namespace App\App\Offers\Controller;

use App\Domain\Auctions\AuctionRepositoryInterface;
use App\Domain\Offers\Offer;
use App\Domain\Offers\OfferRepositoryInterface;
use App\Domain\Users\UserRepositoryInterface;
use App\Domain\Uuid;
use App\Domain\UuidFactory;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class OffersController extends AbstractController
{
    public function __construct(
        private AuctionRepositoryInterface $auctionRepository,
        private OfferRepositoryInterface $offerRepository,
        private UserRepositoryInterface $userRepository,
        private UuidFactory $uuidFactory,
    )
    {
    }

    #[Route('/auctions/{id}/offer', name: 'place_bid', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function placeBid(Request $request): RedirectResponse
    {
        $userId = $this->getUser()->getId();
        if ($userId === null) {
            throw $this->createAccessDeniedException('User not authenticated');
        }

        $user = $this->userRepository->findById($userId);
        $auctionId = $request->get('id');
        $amount = (float)$request->get('bidAmount');
        $auction = $this->auctionRepository->findById(Uuid::fromString($auctionId));

        if ($auction === null) {
            throw $this->createNotFoundException('Auction not found');
        }

        $highestBid = $auction->getHighestOffer() ?? $auction->getStartPrice();
        if ($amount <= $highestBid) {
            $this->addFlash('error', 'Bid amount must be greater than the current highest bid. Current highest bid: ' . $highestBid);
            return $this->redirectToRoute('auctions_show', ['id' => $auctionId]);
        }

        $offer = new Offer();
        $offer->setId($this->uuidFactory->create()->toString());
        $offer->setUser($user);
        $offer->setAuction($auction);
        $offer->setBidAmount($amount);
        $offer->setBidTime(new DateTimeImmutable());

        $this->offerRepository->save($offer);

        $this->addFlash('success', 'Bid placed successfully');
        return $this->redirectToRoute('auctions_show', ['id' => $auctionId]);
    }
}
