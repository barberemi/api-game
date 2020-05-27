<?php

namespace App\Controller;

use App\Manager\UserManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthentificationController
 *
 * @Route("/authentification")
 */
class AuthentificationController
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
     * Create the user.
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
     *     name="email",
     *     in="formData",
     *     type="string",
     *     required=true,
     *     description="The email of user."
     * )
     * @SWG\Parameter(
     *     name="plainPassword",
     *     in="formData",
     *     type="string",
     *     required=true,
     *     description="The plainPassword of user."
     * )
     * @SWG\Tag(name="authentification")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function signUp(Request $request)
    {
        if (!$request->request->has('email')) {
            return new JsonResponse(['error' => 'email is null'], JsonResponse::HTTP_BAD_REQUEST);
        }
        $email = $request->request->get('email');

        if (!$request->request->has('plainPassword')) {
            return new JsonResponse(['error' => 'plainPassword is null'], JsonResponse::HTTP_BAD_REQUEST);
        }
        $plainPassword = $request->request->get('plainPassword');

        try {
            $this->userManager->create($email, $plainPassword);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}
