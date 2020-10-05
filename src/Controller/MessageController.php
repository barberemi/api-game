<?php

namespace App\Controller;

use App\Manager\MessageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MessageController
 *
 * @Route("/messages")
 */
class MessageController extends AbstractController
{
    /**
     * @var MessageManager
     */
    protected $messageManager;

    /**
     * MessageController constructor.
     *
     * @param MessageManager $messageManager
     */
    public function __construct(MessageManager $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    /**
     * Get all messages.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all messages correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="messages")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAll(Request $request)
    {
        try {
            $messages = $this->messageManager->getAll($request->query->all());
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($messages, JsonResponse::HTTP_OK);
    }

    /**
     * Post a message
     *
     * @Route(methods={"POST"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="When user correctly post a message."
     * )
     * @SWG\Response(
     *     response=500,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="message",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *              property="data",
     *              type="object",
     *              @SWG\Schema(
     *                  @SWG\Property(property="user", type="string",  example="Rémi"),
     *                  @SWG\Property(property="message", type="string",  example="Bonjour à tous"),
     *                  @SWG\Property(property="topic", type="string", example="http://localhost:3000/adminMessage"),
     *              ),
     *         ),
     *     )
     * )
     * @SWG\Tag(name="messages")
     *
     * @param Request $request
     * @param PublisherInterface $publisher
     *
     * @return JsonResponse
     */
    public function createMessage(Request $request, PublisherInterface $publisher): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Cannot do that anonymously.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);

        $update = new Update($data['topic'], json_encode(array_merge($data, ["created_at" => (new \DateTime())->format('Y-m-d H:i:s')]), true));
        $publisher($update);

        $this->messageManager->create([
            "user" => [ "id" => $user->getId()],
            "topic" => $data['topic'],
            "message" => $data['message'],
        ]);

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}