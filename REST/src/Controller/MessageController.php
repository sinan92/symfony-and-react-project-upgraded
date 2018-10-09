<?php

namespace App\Controller;

use App\Model\MessageModelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends Controller
{
    /**
     * MessageController constructor.
     */
    private $messageModel;

    /**
     * MessageController constructor.
     * @param $messageModel
     */
    public function __construct(MessageModelInterface $messageModel)
    {
        $this->messageModel = $messageModel;
    }


    /**
     * @Route("/message", name="message")
     */
    public function index()
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    /**
     * @Route("/messages", methods={"GET"}, name="getAll")
     */
    public function getAllMessages()
    {
        $statuscode = 200;
        $messages = [];
        try {
            $messages = $this->messageModel->getAllMessages();
        } catch (\IllegalArgumentExceptions $exception) {
            $statuscode = 500;
        }
        return new JsonResponse($messages, $statuscode);
    }


    /**
     * @Route("/messages/{messageId}", methods={"GET"}, name="getById")
     */
    public function getMessageById($messageId)
    {
        $statuscode = 200;
        $messages = [];
        try {
            $messages = $this->messageModel->getMessageById($messageId);
        } catch (\IllegalArgumentExceptions $exception) {
            $statuscode = 500;
        }
        return new JsonResponse($messages, $statuscode);
    }


    /**
     * @Route("/messages/search/content/{search}", methods={"GET"}, name="saerchByContent")
     */
    public function searchMessageByContent($search)
    {
        $statuscode = 200;
        $messages = [];
        try {
            $messages = $this->messageModel->searchMessageByContent($search);
        } catch (\IllegalArgumentExceptions $exception) {
            $statuscode = 500;
        }
        return new JsonResponse($messages, $statuscode);
    }


    /**
     * @Route("/messages/search/content-and-category/{content}/{category}", methods={"GET"},
     *      name="searchByContentAndCategory", defaults={"content":"t", "category":"t"})
     */
    public function searchByMessageContentAndCategory($content, $category)
    {
        $statuscode = 200;
        $messages = [];
        try {
            $messages = $this->messageModel->searchMessageByContentAndCategory($content, $category);
        } catch (\IllegalArgumentExceptions $exception) {
            $statuscode = 500;
        }
        return new JsonResponse($messages, $statuscode);
    }


    /**
     * @Route("/messages/comment/post/", methods={"POST"}, name="postComment")
     */
    public function postComment(Request $request)
    {
        $statuscode = 201;
        $response = null;
        $messageId = $request->request->get("messageId");
        $comment = $request->request->get("comment");
        try {
            $response = $this->messageModel->postComment($messageId, $comment);
        } catch (\IllegalArgumentExceptions $exception) {
            $statuscode = 500;
        }
        return new JsonResponse($response, $statuscode);
    }


    /**
     * @Route("/messages/upvote/{messageId}", methods={"PUT"}, name="upVoteMessage")
     */
    public function upVoteMessage($messageId)
    {
        $statuscode = 200;
        $response = null;
        try {
            $response = $this->messageModel->upVoteMessage($messageId);
        } catch (\IllegalArgumentExceptions $exception) {
            $statuscode = 500;
        }
        return new JsonResponse($response, $statuscode);
    }


    /**
     * @Route("/messages/downvote/{messageId}", methods={"PUT"}, name="downVoteMessage")
     */
    public function downVoteMessage($messageId)
    {
        $statuscode = 200;
        $response = null;
        try {
            $response = $this->messageModel->downVoteMessage($messageId);
        } catch (\IllegalArgumentExceptions $exception) {
            $statuscode = 500;
        }
        return new JsonResponse($response, $statuscode);
    }
}
