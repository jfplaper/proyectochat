<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Form\ChatType;
use App\Repository\ChatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/chat')]
#[IsGranted("ROLE_USER")]
final class ChatController extends AbstractController
{
    #[Route(name: 'app_chat_index', methods: ['GET'])]
    public function index(ChatRepository $chatRepository): Response
    {
        return $this->render('chat/new.html.twig', [
            'chats' => $chatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ChatRepository $chatRepository): Response
    {   
        $message = $request->get('text');

        $chat = new Chat();
        $chat->setText($message);
        $chat->setTextDate(new \DateTime());
        $chat->setUser($this->getUser());
        
        $entityManager->persist($chat);
        $entityManager->flush();

        return $this->render('main/index.html.twig', [
            'chats' => $chatRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_chat_show', methods: ['GET'])]
    public function show(Chat $chat): Response
    {
        return $this->render('chat/show.html.twig', [
            'chat' => $chat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chat $chat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChatType::class, $chat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat/edit.html.twig', [
            'chat' => $chat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chat_delete', methods: ['POST'])]
    public function delete(Request $request, Chat $chat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
    }
}
