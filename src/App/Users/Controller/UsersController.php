<?php

declare(strict_types=1);

namespace App\App\Users\Controller;

use App\App\Users\Form\LoginType;
use App\App\Users\Form\RegisterType;
use App\Domain\Users\User;
use App\Domain\Users\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // todo login
        }

        return $this->render('users/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register', name: 'register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $this->userRepository->save($user);

            return $this->redirectToRoute('login');
        }

        return $this->render('users/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
