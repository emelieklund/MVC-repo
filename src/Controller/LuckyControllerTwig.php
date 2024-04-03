<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky", name: "lucky_color")]
    public function number(): Response
    {
        $number = random_int(100, 999999);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky.html.twig', $data);
    }
}
