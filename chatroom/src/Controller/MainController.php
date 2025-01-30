<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Form\ChatType;
use App\Repository\ChatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ChatRepository $chatRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'chats' => $chatRepository->findAll(),
        ]);
    }
}
