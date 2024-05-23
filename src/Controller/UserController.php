<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/proj/users', name: 'users_view')]
    public function viewAllUsers(
        UserRepository $userRepository
    ): Response
    {
        $users = $userRepository->findAll();

        $data = [
            'users' => $users,
        ];

        return $this->render('poker-squares/users.html.twig', $data);
    }

    #[Route('/proj/user/add', name: 'add_user')]
    public function addUser(
        UserRepository $userRepository
    ): Response
    {
        return $this->render('poker-squares/add_user.html.twig');
    }

    #[Route('/proj/user/add/post', name: 'post_user', methods: ['POST'])]
    public function postUser(
        Request $request,
        ManagerRegistry $doctrine,
    ): Response {
        $entityManager = $doctrine->getManager();

        $username = $request->request->get('username');
        $account = $request->request->get('account');

        $user = new User();
        $user->setUsername($username);
        $user->setAccount($account);

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->redirectToRoute('users_view');
    }

    #[Route('/proj/user/bet', name: 'user_bet')]
    public function userBet(
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine,
        UserRepository $userRepository
    ): Response {
        $entityManager = $doctrine->getManager();

        $username = $session->get("username");
        $points = $session->get("points");
        $cash = $session->get("cash");

        $user = $userRepository->findIdByUsername($username);

        var_dump($user);

        //$account = $user->getAccount();
        $user->setAccount($cash);

        $entityManager->persist($user);

        $entityManager->flush();

        return $this->redirectToRoute('users_view');
    }
}
