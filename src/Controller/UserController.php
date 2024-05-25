<?php

namespace App\Controller;

use App\Card\Betting;

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
    ): Response {
        $users = $userRepository->findAll();

        $data = [
            'users' => $users,
        ];

        return $this->render('poker-squares/users.html.twig', $data);
    }

    #[Route('/proj/user/add', name: 'add_user')]
    public function addUser(
        UserRepository $userRepository
    ): Response {
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

    #[Route('/proj/user/bet/{id}', name: 'user_bet')]
    public function userBet(
        int $id,
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine,
        UserRepository $userRepository
    ): Response {
        $entityManager = $doctrine->getManager();

        $pointsGuessed = $session->get("points_guessed");
        $bet = $session->get("bet");
        $score = $session->get("score");

        $user = $entityManager->getRepository(User::class)->find($id);

        $betting = new Betting($pointsGuessed, $score);

        $profitOrLoss = $betting->pointChecker();

        $account = $user->getAccount();

        if ($profitOrLoss > 1) {
            $user->setAccount(($profitOrLoss * $bet) - $bet + $account);
        } else {
            $user->setAccount($account - ($profitOrLoss * $bet) - $bet); //fixa den här
        }

        $entityManager->persist($user);

        $entityManager->flush();

        $data = [
            "points_guessed" => $pointsGuessed,
            "score" => $score,
            "bet" => $bet,
            "profit_or_loss" => $profitOrLoss,
        ];

        return $this->render('poker-squares/result.html.twig', $data);
    }

}
