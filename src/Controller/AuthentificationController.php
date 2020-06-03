<?php

namespace App\Controller;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthentificationController
 *
 * @Route("/auth")
 */
class AuthentificationController extends AbstractController
{
    /**
     * @var UserManager userManager
     */
    protected $userManager;

    /**
     * AuthentificationController constructor.
     *
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Create an user.
     *
     * @Route("/signup", methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="When user created correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Response(
     *     response=409,
     *     description="When an user already exists with this email."
     * )
     * @SWG\Parameter(
     *     name="user",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="email", type="string", example="toto@gmail.com"),
     *         @SWG\Property(property="password", type="string", example="totoDu56%"),
     *     )
     * )
     * @SWG\Tag(name="auth")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function signUp(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!$data['email']) {
            return new JsonResponse(['error' => 'email is null'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (!$data['password']) {
            return new JsonResponse(['error' => 'password is null'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->userManager->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/login_check", methods={"POST"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="When user login check correctly."
     * )
     * @SWG\Response(
     *     response=500,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="user",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="email", type="string", example="test@gmail.com"),
     *         @SWG\Property(property="password", type="string", example="blabla"),
     *     )
     * )
     * @SWG\Tag(name="auth")
     *
     * @return JsonResponse
     */
    public function checkLogin(): Response
    {
        $user = $this->getUser();

        return new Response([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
}
