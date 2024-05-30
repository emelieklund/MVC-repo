<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Highscore;
use App\Repository\HighscoreRepository;

use App\Entity\User;
use App\Repository\UserRepository;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JSONPokerSquaresController extends AbstractController
{
    #[Route("/proj/api", name: "proj_api")]
    public function pokerRoutes(): Response
    {
        return $this->render('poker-squares/poker_json_routes.html.twig');
    }

    #[Route("/proj/api/highscore", name: "json_highscore", format: 'json')]
    public function jsonHighScore(HighScoreRepository $highScoreRepository): Response
    {
        $highScore = $highScoreRepository->findAll();

        $response = $this->json($highScore);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/proj/api/columns", name: "json_columns", format: 'json')]
    public function jsonColumns(SessionInterface $session): Response
    {
        $gameBoard = $session->get("game_board");

        $columns = $gameBoard->columns();

        $response = $this->json($columns);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/proj/api/rows", name: "json_rows", format: 'json')]
    public function jsonRows(SessionInterface $session): Response
    {
        $gameBoard = $session->get("game_board");

        $rows = $gameBoard->rows();

        $response = $this->json($rows);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/proj/api/users", name: "json_users", format: 'json')]
    public function jsonUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        $response = $this->json($users);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/proj/api/users/one", name: "json_one_user", format: 'json', methods: ['POST'])]
    public function jsonOneUser(
        UserRepository $userRepository,
        Request $request
    ): Response
    {
        $username = $request->request->get('user');
        $user = $userRepository->findUserByUsername($username);

        $response = $this->json($user);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}