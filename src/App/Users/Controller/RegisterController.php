<?php

declare(strict_types=1);

namespace App\App\Users\Controller;

use App\App\Users\Form\RegisterType;
use App\Domain\Users\User;
use App\Domain\Users\UserRepositoryInterface;
use App\Domain\UuidFactory;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private UuidFactory $uuidFactory,
    ) {
    }

    #[Route('/register', name: 'register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $userData = $form->getData();
            $user = new User(
                $this->uuidFactory->create()->toString(),
                $userData['name'],
                $userData['email'],
                password_hash($userData['password'], PASSWORD_DEFAULT),
                new DateTimeImmutable(),
                new DateTimeImmutable(),
            );

            $this->userRepository->save($user);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
