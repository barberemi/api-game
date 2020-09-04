<?php

namespace App\Controller;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @Route("/users")
 */
class UserController extends AbstractController
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * UserController constructor.
     *
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Get a user.
     *
     * @Route("/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get user correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="users")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function index(int $id)
    {
        try {
            $user = $this->userManager->get($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }

    /**
     * Get all users.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all users correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="users")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAll(Request $request)
    {
        try {
            $users = $this->userManager->getAll($request->query->all());
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($users, JsonResponse::HTTP_OK);
    }

    /**
     * Update a user.
     *
     * @Route("/{id}", methods={"PUT"})
     * @SWG\Response(
     *     response=200,
     *     description="When user updated correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="user",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="money", type="number", example=1000),
     *     )
     * )
     * @SWG\Tag(name="users")
     *
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $user = $this->userManager->update($id, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }

    /**
     * Delete a user.
     *
     * @Route("/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="When user deleted correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="users")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->userManager->delete($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }
}
