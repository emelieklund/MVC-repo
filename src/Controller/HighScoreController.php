<?php

namespace App\Controller;

use App\Entity\Highscore;
use App\Repository\HighscoreRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HighScoreController extends AbstractController
{
    #[Route('/proj/highscore', name: 'highscore_view')]
    public function viewAll(
        HighScoreRepository $highScoreRepository
    ): Response {
        $highScore = $highScoreRepository->findAll();

        $data = [
            'high_score' => $highScore,
        ];

        return $this->render('poker-squares/high_scores.html.twig', $data);
    }

    #[Route('/proj/highscore/save', name: 'save_score', methods: ['POST'])]
    public function saveHighScore(
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine,
    ): Response {
        $entityManager = $doctrine->getManager();

        $name = $request->request->get('name');
        $score = $request->request->get('score');

        $session->set("score", $score);

        $highScore = new Highscore();
        $highScore->setName($name);
        $highScore->setScore($score);

        $entityManager->persist($highScore);

        $entityManager->flush();

        if ($session->has("id")) {
            return $this->redirectToRoute('user_bet', ['id' => $session->get("id")]);
        }

        return $this->redirectToRoute('highscore_view');
    }

    #[Route('/proj/highscore/delete/{id}', name: 'highscore_delete')]
    public function deleteHighScore(
        int $id,
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine,
    ): Response {
        $entityManager = $doctrine->getManager();
        $highscore = $entityManager->getRepository(Highscore::class)->find($id);

        if (!$highscore) {
            throw $this->createNotFoundException(
                'No highscore found for id '.$id
            );
        }

        $entityManager->remove($highscore);
        $entityManager->flush();

        return $this->redirectToRoute('highscore_view');
    }
}
