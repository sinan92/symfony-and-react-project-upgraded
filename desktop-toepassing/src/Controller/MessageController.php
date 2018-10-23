<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Category;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    // Rechten:
    // Als ik praat over een poster, dan heeft de modarator natuurlijk ook de rechten om die functie uit te voeren
    // maar een anonieme gebruiker niet.

    // moderator only
    public function deleteAllMessagesFromPoster(string $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $messages = $entityManager->getRepository('appBundle:Message')->findBy(array('name' => $user));
        if (!$messages)
        {
            throw $this->createNotFoundException(
                'No messages found for user '.$user
            );
        }
        foreach ($messages as $message)
        {
            $entityManager->remove($message);
        }
        $entityManager->flush();
    }

    //Moderator kan alleen categorieen posten
    public function postCategory(Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();
        return new Response('Saved new Category ' . $category);
    }

    // Anonieme gebruikers kunnen zoeken in messages
    /**
     * @Route("/message/find?id={id}", name="getAllMessages")
     */
    public function getMessage($id)
    {
        $messages = $this->getDoctrine()->getManager()->getRepository(Message::class)->find($id);
        return $this->render('message/index.html.twig', array('messages' => $messages,
            'controller_name' => 'Message Controller'));
    }

    // anonieme gebruikers
    // we moeten gebruik maken van paginatie.
    /**
     * @Route("/message/getAll", name="getAllMessages")
     */
    public function getMessages()
    {
        $messages = $this->getDoctrine()->getManager()->getRepository(Message::class)->findAll();

        return $this->render('message/index.html.twig', array('messages' => $messages,
            'controller_name' => 'Message Controller'));
    }

    // posters kunnen berichten aanmaken in bestaande categorie
    /**
     * @Route("/message/post", name="postMessage")
     */
    public function postMessage(Message $message)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();
        return new Response('Saved new Message ' . $message);
    }

    // poster kan alleen eigen message updaten
    public function updateMessage(int $id, string $newContent, Category $newCategory)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $message =  $entityManager->getRepository(message::class)->find($id);
        if (!$message)
        {
            throw $this->createNotFoundException(
                'No message found for id '.$id
            );
        }
        $message->setContent($newContent);
        $message->setCategory($newCategory);
        $entityManager->flush();
    }

    // poster kan alleen eigen message deleten
    public function deleteMessage(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $message = $entityManager->getRepository('appBundle:Message')->find($id);
        if (!$message)
        {
            throw $this->createNotFoundException(
                'No message found for id '.$id
            );
        }
        $entityManager->remove($message);
        $entityManager->flush();
    }

    // anoniem
    // link naar message
    // Bij het aanmaken krijgt de gebruiker het token en id van de reactie.
    public function postComment(Comment $comment)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        return new Response('Saved new Comment ' . $comment);
    }

    //De gebruiker kan wijzigen en verwijderen adhv het
    //token dat hoort bij het bericht 1pt
    public function updateComment(int $id, string $newContent)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment =  $entityManager->getRepository(Comment::class)->find($id);
        if (!$comment)
        {
            throw $this->createNotFoundException(
                'No comment found for id '.$id
            );
        }
        $comment->setContent($newContent);
        $entityManager->flush();
    }

    //De gebruiker kan wijzigen en verwijderen adhv het
    //token dat hoort bij het bericht 1pt
    public function deleteComment(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository('appBundle:Comment')->find($id);
        if (!$comment)
        {
            throw $this->createNotFoundException(
                'No comment found for id '.$id
            );
        }
        $entityManager->remove($comment);
        $entityManager->flush();
    }

}