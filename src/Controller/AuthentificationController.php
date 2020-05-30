<?php

namespace App\Controller;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AuthentificationController
 *
 * @Route("/authentification")
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
     *         @SWG\Property(property="plainPassword", type="string", example="totoDu56%"),
     *     )
     * )
     * @SWG\Tag(name="authentification")
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

        if (!$data['plainPassword']) {
            return new JsonResponse(['error' => 'plainPassword is null'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->userManager->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    /**
     * Login.
     *
     * @Route("/login", methods={"GET", "POST"})
     * @SWG\Response(
     *     response=200,
     *     description="When user login correctly."
     * )
     * @SWG\Response(
     *     response=500,
     *     description="When some errors on params."
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
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * Logout.
     *
     * @Route("/logout", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When user logout correctly."
     * )
     * @SWG\Response(
     *     response=500,
     *     description="When some errors."
     * )
     * @SWG\Tag(name="authentification")
     *
     */
    public function logout()
    {
    }
}
