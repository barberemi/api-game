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
     *     response=201,
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

        return new JsonResponse($user, JsonResponse::HTTP_CREATED);
    }

    /**
     * Get all users.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=201,
     *     description="When get all users correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page number.",
     *     type="integer",
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
            $page = $request->query->get('page');
            if(is_null($page) || $page < 1) {
                $page = 1;
            }

            $users = $this->userManager->getAll($page);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($users, JsonResponse::HTTP_CREATED);
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
