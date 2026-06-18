<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    private $messages = [
        "meep",
        "moop",
        "maap"
    ];

    #[Route('/{limit?}', name: 'app_index', requirements: ['limit' => '\d+'])]
    public function index(?int $limit = 3): Response
    {
        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => $this->messages,
                'limit' => $limit
            ]
        );
    }

    #[Route('/message/{id}', name: "app_show_one", requirements: ['id' => '\d+'])]
    public function showOne(int $id): Response {
        return $this->render(
            'hello/show_one.html.twig',
            [
                'message' => $this->messages[$id]
            ]
        );
    }
}
