<?php

namespace App\Controller;

use App\Card\Betting;

use App\Entity\User;
use App\Repository\UserRepository;

use App\Entity\Highscore;
use App\Repository\HighscoreRepository;

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
    public function addUser(): Response {
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
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $pointsGuessed = $session->get("points_guessed");
        $bet = $session->get("bet");
        $score = $session->get("score");

        $user = $entityManager->getRepository(User::class)->find($id);

        $betting = new Betting($pointsGuessed, $score);

        $profitOrLoss = $betting->pointChecker();

        $account = $user->getAccount();
        $recentScore = $user->getScore();

        if ($score >= $pointsGuessed) {
            $user->setAccount(($profitOrLoss * $bet) - $bet + $account);
        } else {
            $user->setAccount($account - ($profitOrLoss * $bet));
        }

        if ($score > $recentScore) {
            $user->setScore($score);
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

    #[Route('/proj/user/delete/{id}', name: 'user_delete')]
    public function deleteUser(
        int $id,
        ManagerRegistry $doctrine,
    ): Response {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('users_view');
    }

    #[Route('/proj/user/reset', name: 'reset')]
    public function resetDatabase(
        UserRepository $userRepository,
        HighScoreRepository $highScoreRepository,
        ManagerRegistry $doctrine
    ): Response {
        $users = $userRepository->findAll();
        $highScores = $highScoreRepository->findAll();

        $entityManager = $doctrine->getManager();

        foreach ($users as $user) {
            $entityManager->remove($user);
        }

        foreach ($highScores as $highScore) {
            $entityManager->remove($highScore);
        }

        $entityManager->flush();

        return $this->redirectToRoute('about_database');
    }
}
