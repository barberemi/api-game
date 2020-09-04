<?php

namespace App\Controller;

use App\Manager\AcademyManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AcademyController
 *
 * @Route("/academies")
 */
class AcademyController extends AbstractController
{
    /**
     * @var AcademyManager
     */
    protected $academyManager;

    /**
     * AcademyController constructor.
     *
     * @param AcademyManager $academyManager
     */
    public function __construct(AcademyManager $academyManager)
    {
        $this->academyManager = $academyManager;
    }

    /**
     * Get a academy.
     *
     * @Route("/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get academy correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="academies")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function index(int $id)
    {
        try {
            $academy = $this->academyManager->get($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($academy, JsonResponse::HTTP_OK);
    }

    /**
     * Get all academies.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all academies correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="academies")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAll(Request $request)
    {
        try {
            $academies = $this->academyManager->getAll($request->query->all());
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($academies, JsonResponse::HTTP_OK);
    }

    /**
     * Create a academy.
     *
     * @Route(methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="When academy created correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="academy",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="Paladin"),
     *         @SWG\Property(property="description", type="string", example="Très résistant, il se bat toujours pour défendre ses frères d'arme."),
     *     )
     * )
     * @SWG\Tag(name="academies")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->academyManager->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a academy.
     *
     * @Route("/{id}", methods={"PUT"})
     * @SWG\Response(
     *     response=200,
     *     description="When academy updated correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="academy",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="Paladin"),
     *         @SWG\Property(property="description", type="string", example="Très résistant, il se bat toujours pour défendre ses frères d'arme."),
     *     )
     * )
     * @SWG\Tag(name="academies")
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
            $academy = $this->academyManager->update($id, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($academy, JsonResponse::HTTP_OK);
    }

    /**
     * Delete a academy.
     *
     * @Route("/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="When academy deleted correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="academies")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->academyManager->delete($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }
}
